<?php

namespace Modules\Prospect\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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

        return view('prospect::index', [
            'prospects' => $prospects,
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

        return view('prospect::create', [
            'users' => $activeUsers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
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
     * @return Renderable
     */
    public function show($id)
    {
        $prospect = Prospect::with('pocUser')->find($id);

        return view('prospect::subviews.show', [
            'prospect' => $prospect,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $prospect = Prospect::find($id);
        $user = new User();
        $activeUsers = $user->active_users;
        return view('prospect::edit', [
            'prospect' => $prospect,
            'users' => $activeUsers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validated();
        $this->service->update($validated, $id);
        return redirect()->route('prospect.index')->with('status', 'Prospect updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
