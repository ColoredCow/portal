<?php

namespace Modules\Prospect\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Client;
use Modules\Client\Entities\Country;
use Modules\Prospect\Entities\Prospect;
use Modules\Prospect\Http\Requests\ProspectRequest;
use Modules\Prospect\Services\ProspectService;
use Modules\User\Entities\User;

class ProspectController extends Controller
{
    protected $service;

    public function __construct(ProspectService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $requestData = request()->all();
        $data = $this->service->index($requestData);

        return view('prospect::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $countries = Country::all();
        $activeUsers = User::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();

        return view('prospect::create', [
            'users' => $activeUsers,
            'countries' => $countries,
            'clients' => $clients,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param \Modules\Prospect\Http\Requests\ProspectRequest $request
     */
    public function store(ProspectRequest $request)
    {
        $validated = $request->validated();
        $this->service->store($validated);

        return redirect()->route('prospect.index')->with('status', 'Prospect created successfully!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
        $prospect = Prospect::with(['comments', 'insights'])->find($id);
        $countries = Country::all();
        $currencySymbols = $countries->pluck('currency_symbol', 'currency');

        return view('prospect::subviews.show', [
            'prospect' => $prospect,
            'currencySymbols' => $currencySymbols,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $prospect = Prospect::with(['comments'])->find($id);
        $countries = Country::all();
        $activeUsers = User::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();

        return view('prospect::edit', [
            'prospect' => $prospect,
            'users' => $activeUsers,
            'countries' => $countries,
            'clients' => $clients,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Prospect $prospect
     */
    public function update(Request $request, Prospect $prospect)
    {
        $data = $this->service->update($request, $prospect);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function commentUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'prospect_comment' => 'required',
        ]);
        $this->service->commentUpdate($validated, $id);

        return redirect()->route('prospect.show', $id)->with('status', 'Comment updated successfully!');
    }

    public function insightsUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'insight_learning' => 'required',
        ]);
        $this->service->insightsUpdate($validated, $id);

        return redirect()->route('prospect.show', $id)->with('status', 'Prospect Insights updated successfully!');
    }
}
