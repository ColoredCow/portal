<?php

namespace Modules\ProjectContract\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Client;
use Modules\ProjectContract\Http\Requests\ProjectContractRequest;
use Modules\ProjectContract\Entities\ProjectContractMeta;

class ProjectContractController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $clients = Client::all();
        $projectContracts = ProjectContractMeta::all();

        return view('projectcontract::index', compact('clients', 'projectContracts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('projectcontract::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param ProjectContractRequest $request
     * @return Renderable
     */
    public function store(ProjectContractRequest $request)
    {
        $validated = $request->validated();
        $clientId = Client::select('id')->where('name', $validated['client_name'])->first()->id;
        ProjectContractmeta::create([
            'client_id' => $clientId,
            'website_url' => $validated['website_url'],
            'logo_img' => $validated['logo_img'],
            'authority_name' => $validated['authority_name'],
            'contract_date_for_signing' => $validated['contract_date_for_signing'],
            'contract_date_for_effective' => $validated['contract_date_for_effective'],
            'contract_expiry_date' => $validated['contract_expiry_date'],
            'attributes' => json_encode($validated['attributes']),
        ]);

        $clients = Client::all();

        return view('projectcontract::index', compact('clients'))->with('success', 'Project Contract created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client, ProjectContractMeta $projectcontract)
    {
        return view('projectcontract::edit');
    }
}
