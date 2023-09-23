<?php

namespace Modules\ContractSettings\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ContractSettings\Entities\ContractSettings;

class ContractSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $contracts = ContractSettings::all();
        return view('contractsettings::index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('contractsettings::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'contract_type' => 'required',
            'contract_template' => 'required',
        ]);

        ContractSettings::create($request->post());

        return redirect()->route('contractsettings.index')->with('success','Template Added Successfully!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('contractsettings::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    // public function edit(ContractSettings $contract)
    // {
    //     return view('contractsettings::edit',compact('contract'));
    // }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, ContractSettings $contract)
    {
        $request->validate([
            'contract_type' => 'required',
            'contract_template' => 'required',
        ]);

        $contract->fill($request->post())->save();

        return redirect()->route('contractsettings::index')->with('success','Template Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(ContractSettings $contract)
    {
        $contract->delete();
        return redirect()->back();
    }
}
