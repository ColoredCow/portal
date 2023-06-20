<?php

namespace Modules\ProjectContract\Services;

use Illuminate\Support\Facades\Auth;
use Modules\ProjectContract\Entities\Contract;
use Modules\ProjectContract\Entities\ProjectContractMeta;
use Modules\ProjectContract\Http\Requests\ProjectContractRequest;
use Modules\ProjectContract\Entities\Reviewer;
use Modules\ProjectContract\Entities\ContractReview;
use Modules\ProjectContract\Entities\ContractInternalReview;
use Modules\ProjectContract\Entities\ContractMetaHistory;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;

class ProjectContractService
{
    public function index()
    {
        return Contract::where('contracts.user_id', Auth::id())->get();
    }
    public function internal_reviewer()
    {
        return Contract::join('contract_internal_reviewer', 'contracts.id', '=', 'contract_internal_reviewer.contract_id')->where('contract_internal_reviewer.user_id', Auth::id())->get();
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

        $contractId = null;

        DB::transaction(function () use ($contractData, $contractMeta, &$contractId) {
            $contract = Contract::create($contractData);

            foreach ($contractMeta as $meta) {
                $contract->contractMeta()->create($meta);
            }

            $contractId = $contract->id;
        });

        return $contractId;
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
    public function view_internal_reviewer($id)
    {
        return ContractInternalReview::find($id);
    }
    public function view_comments($id)
    {
        if (ContractReview::find($id)) {
            return ContractReview::where('contract_id', '=', $id)->orderBy('created_at', 'desc')->get();
        }
    }
    public function update_contract($id)
    {
        $Contract = Contract::find($id);
        $Contract->status = 'Finalise by client';
        $Contract->save();

        return $Contract;
    }
    public function update_internal_contract($id)
    {
        $Contract = Contract::find($id);
        if ($Contract->user_id == Auth::id()) {
            $Contract->status = 'Finalise by User';
        } else {
            $Contract->status = 'Finalise by finance';
        }
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
        $contractId = $request['id'];

        $contractReview = new ContractReview();
        $contractReview->contract_id = $contractId;
        $contractReview->comment = $request['comment'];

        $id = Reviewer::find($request['rid']);
        $contractReview->comment()->associate($id);
        $contractReview->save();

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

        DB::transaction(function () use ($contractId, $contractData, $contractMeta, $contractReview) {
            $contract = Contract::where('id', $contractId)->first();
            $contract->update($contractData);
            $existingMeta = $contract->contractMeta()->where('contract_id', $contractId)->get();
    
            foreach ($contractMeta as $meta) {
                $contract->contractMeta()->updateOrCreate(['key' => $meta['key']], ['value' => $meta['value']]);
                foreach ($existingMeta as $emeta) {
                    if ($emeta->key == $meta['key'] and $emeta->value != $meta['value']) {
                        $contract->contractMetaHistory()->create([
                            'contract_id' => $contract->id,
                            'key' => $meta['key'],
                            'value' => $emeta['value'],
                            'review_id' => $contractReview->id,
                            'has_changed' => true

                        ]);
                    } elseif ($emeta->key == $meta['key'] and $emeta->value == $meta['value']) {
                        $contract->contractMetaHistory()->create([
                            'contract_id' => $contract->id,
                            'key' => $meta['key'],
                            'value' => $emeta['value'],
                            'review_id' => $contractReview->id,
                        ]);
                    }
                }
            }
        });

        return $contractData;
    }
    

    public function store_internal_reveiwer($request)
    {
        $id = $request['id'];
        $name = $request['name'];
        $email = $request['email'];

        $Reviewer = new ContractInternalReview;
        $Reviewer->contract_id = $id;
        $Reviewer->name = $name;
        $Reviewer->email = $email;
        $User = User::findByEmail($email);
        $Reviewer->user_id = $User->id;
        $Reviewer->save();

        $Contract = Contract::find($id);
        $Contract->status = 'Sent for finance review';
        $Contract->save();

        return $Reviewer;
    }
    public function update_internal($request)
    {
        $contractReview = new ContractReview();
        $contractReview->contract_id = $request['id'];
        $contractReview->comment = $request['comment'];
        $id = ContractInternalReview::find($request['rid']);
        $contractReview->comment()->associate($id);
        $contractReview->save();

        $contractData = [
            'contract_name' => $request['client_name'],
            'status' => 'Updated by finance',
        ];

        $id = Contract::where('id', $request['id'])->first();
        if ($id->user_id == Auth::id()) {
            $contractData['status'] = 'Updated by CC team';
        }
        $contractMeta = [
            ['key' => 'Contract Name', 'value' => $request['contract_name']],
            ['key' => 'Contract Date For Effective', 'value' => $request['contract_date_for_effective']],
            ['key' => 'Contract Date For Signing', 'value' => $request['contract_date_for_signing']],
            ['key' => 'Contract Date For Expiry', 'value' => $request['contract_expiry_date']],
        ];

        DB::transaction(function () use ($request, $contractData, $contractMeta, $contractReview) {
            $contract = Contract::where('id', $request['id'])->first();
            $contract->update($contractData);
            $existingMeta = $contract->contractMeta()->where('contract_id', $request['id'])->get();
            

            foreach ($contractMeta as $meta) {
                $contract->contractMeta()->updateOrCreate(['key' => $meta['key']], ['value' => $meta['value']]);
                foreach ($existingMeta as $emeta) {
                    if ($emeta->key == $meta['key'] and $emeta->value != $meta['value']){
                        $contract->contractMetaHistory()->create([
                            'contract_id' => $contract->id,
                            'key' => $meta['key'],
                            'value' => $emeta['value'],
                            'review_id' => $contractReview->id,
                            'has_changed' => true
                        ]);
                    } elseif ($emeta->key == $meta['key'] and $emeta->value == $meta['value']){
                        $contract->contractMetaHistory()->create([
                            'contract_id' => $contract->id,
                            'key' => $meta['key'],
                            'value' => $emeta['value'],
                            'review_id' => $contractReview->id,
                        ]);
                    }
                }
            }
        });

        return $contractData;
    }
    public function store_user($id)
    {
        $Reviewer = new ContractInternalReview;
        $Reviewer->contract_id = $id;
        $Reviewer->name = Auth::user()->name;
        $Reviewer->email = Auth::user()->email;
        $Reviewer->user_id = Auth::id();
        $Reviewer->save();

        return $Reviewer;
    }
    public function get_comment_history($id)
    {
        return ContractMetaHistory::join('contract_review', 'contract_meta_history.review_id', '=', 'contract_review.id')->where('contract_meta_history.review_id', $id)->get();
    }
    public function get_user_email($id)
    {
        $contract = Contract::find($id);
        $user = User::find($contract->id);

        return $user->email;
    }
}
