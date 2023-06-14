<?php

namespace Modules\ProjectContract\Services;

use Illuminate\Support\Facades\Auth;
use Modules\ProjectContract\Entities\Contract;
use Modules\ProjectContract\Entities\ProjectContractMeta;
use Modules\ProjectContract\Http\Requests\ProjectContractRequest;
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
}
