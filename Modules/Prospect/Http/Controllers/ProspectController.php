<?php

namespace Modules\Prospect\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
        $prospects = Prospect::with('pocUser')->get();
        $countries = Country::all();
        $currencySymbols = $countries->pluck('currency_symbol', 'currency');

        return view('prospect::index', [
            'prospects' => $prospects,
            'currencySymbols' => $currencySymbols,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $user = new User();
        $activeUsers = $user->active_users;
        $countries = Country::all();

        return view('prospect::create', [
            'users' => $activeUsers,
            'countries' => $countries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param \Modules\Prospect\Http\Requests\ProspectRequest $request
     */
    public function store(ProspectRequest $request)
    {
        $validated = $request->validated();
        $data = $this->service->store($validated);

        return $data;
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
        $prospect = Prospect::with(['pocUser', 'comments', 'comments.user'])->find($id);
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
        $prospect = Prospect::with(['pocUser', 'comments'])->find($id);
        $user = new User();
        $activeUsers = $user->active_users;
        $countries = Country::all();

        return view('prospect::edit', [
            'prospect' => $prospect,
            'users' => $activeUsers,
            'countries' => $countries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        $data = $this->service->update($request, $id);

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
}
