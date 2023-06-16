<?php

namespace Modules\ProjectContract\Services;

use Illuminate\Support\Facades\Auth;
use Modules\ProjectContract\Entities\Contract;
use Modules\ProjectContract\Entities\ProjectContractMeta;
use Modules\ProjectContract\Http\Requests\ProjectContractRequest;
use Modules\ProjectContract\Entities\Reviewer;
use Illuminate\Support\Facades\DB;

class ProjectContractService
{
    public function index()
    {
        return Contract::where('contracts.user_id', Auth::id())->get();
    }
    public function store($request)
    {
        $contractData = [
            'user_id' => Auth::id(),
            'contract_name' => $request['client_name'],
            'status' => 'Saved as draft',
        ];

        $contractMeta = [
            ['key' => 'Contract Name', 'value' => $request['contract_name']],
            ['key' => 'Contract Date For Effective', 'value' => $request['contract_date_for_effective']],
            ['key' => 'Contract Date For Signing', 'value' => $request['contract_date_for_signing']],
            ['key' => 'Contract Date For Expiry', 'value' => $request['contract_expiry_date']],
        ];

        DB::transaction(function () use ($contractData, $contractMeta) {
            $contract = Contract::create($contractData);

            foreach ($contractMeta as $meta) {
                $contract->contractMeta()->create($meta);
            }
        });

        return $contractMeta;
    }

    public function delete($id)
    {
        return ProjectContractMeta::find($id)->delete();
    }

    public function update(ProjectContractRequest $request, $id)
    {
        if ($request->hasFile('logo_img')) {
            $file = $request->file('logo_img');
            $path = 'app/public/contractlogo';
            $imageName = $file->getClientOriginalName();
            $fullpath = $file->move(storage_path($path), $imageName);
        }
        $validated = $request->validated();
        $ProjectContractMeta = ProjectContractMeta::find($id);

        $ProjectContractMeta->client_id = $request->get('client_id');
        $ProjectContractMeta->website_url = $validated['website_url'];
        $ProjectContractMeta->logo_img = $validated['logo_img'];
        $ProjectContractMeta->authority_name = $validated['authority_name'];
        $ProjectContractMeta->contract_date_for_signing = $validated['contract_date_for_signing'];
        $ProjectContractMeta->contract_date_for_effective = $validated['contract_date_for_effective'];
        $ProjectContractMeta->contract_expiry_date = $validated['contract_expiry_date'];
        $ProjectContractMeta->attributes = json_encode($request['attributes']);
        $ProjectContractMeta->save();

        return $ProjectContractMeta;
    }
    public function view_contract($id)
    {
        return Contract::find($id);
    }
    public function view_contractmeta($id)
    {
        return Contract::find($id)->contractMeta()->get();
    }
    public function view_reviewer($id, $email)
    {
        return Reviewer::where(['contract_id'=>$id, 'email'=>$email])->first();
    }
    public function update_contract($id)
    {
        $Contract = Contract::find($id);
        $Contract->status = 'Finalise by client';
        $Contract->save();

        return $Contract;
    }
    public function store_reveiwer($request)
    {
        $id = $request['id'];
        $name = $request['name'];
        $email = $request['email'];

        $Reviewer = new Reviewer;
        $Reviewer->contract_id = $id;
        $Reviewer->name = $name;
        $Reviewer->email = $email;
        $Reviewer->save();

        $Contract = Contract::find($id);
        $Contract->status = 'Sent for client review';
        $Contract->save();

        return $Reviewer;
    }
    public function edit_contract($request)
    {
        $contractData = [
            'contract_name' => $request['client_name'],
            'status' => 'Updated by client',
        ];

        $contractMeta = [
            ['key' => 'Contract Name', 'value' => $request['contract_name']],
            ['key' => 'Contract Date For Effective', 'value' => $request['contract_date_for_effective']],
            ['key' => 'Contract Date For Signing', 'value' => $request['contract_date_for_signing']],
            ['key' => 'Contract Date For Expiry', 'value' => $request['contract_expiry_date']],
        ];

        DB::transaction(function () use ($request, $contractData, $contractMeta) {
            $contract = Contract::where('id', $request['id'])->first();
            $contract->update($contractData);

            foreach ($contractMeta as $meta) {
                $contract->contractMeta()->updateOrCreate(['key' => $meta['key']], ['value' => $meta['value']]);
            }
        });

        return $contractData;
    }
}
