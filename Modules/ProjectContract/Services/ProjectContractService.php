<?php

namespace Modules\ProjectContract\Services;

use Illuminate\Support\Facades\Auth;
use Modules\ProjectContract\Entities\Contract;
use Modules\ProjectContract\Entities\ContractMeta;
use Modules\ProjectContract\Entities\ProjectContractMeta;
use Modules\ProjectContract\Http\Requests\ProjectContractRequest;

class ProjectContractService
{
    public function index()
    {
        return ProjectContractMeta::with('client')->orderBy('created_at', 'desc')->get();
    }

    public function store($request)
    {
        $Contract = new Contract;
        $ProjectContractMeta = new ContractMeta;

        $Contract->user_id = Auth::id();
        $Contract->contract_name = $request['client_name'];
        $Contract->save();
        
        $ProjectContractMeta->contract_id = $Contract->id;
        $ProjectContractMeta->key = "Contract Name";
        $ProjectContractMeta->value = $request['contract_name'];
        $ProjectContractMeta->save();

        $ProjectContractMeta->contract_id = $Contract->id;
        $ProjectContractMeta->key = "Contract Date For Effective";
        $ProjectContractMeta->value = $request['contract_date_for_effective'];
        $ProjectContractMeta->save();

        $ProjectContractMeta->contract_id = $Contract->id;
        $ProjectContractMeta->key = "Contract Date For Signing";
        $ProjectContractMeta->value = $request['contract_date_for_signing'];
        $ProjectContractMeta->save();

        $ProjectContractMeta->contract_id = $Contract->id;
        $ProjectContractMeta->key = "Contract Date For Expiry";
        $ProjectContractMeta->value = $request['contract_expiry_date'];
        $ProjectContractMeta->save();

        return $ProjectContractMeta;
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
