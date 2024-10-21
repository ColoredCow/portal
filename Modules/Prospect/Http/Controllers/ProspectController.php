<?php

namespace Modules\Prospect\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Prospect\Entities\Prospect;
use Modules\Prospect\Http\Requests\ProspectRequest;
use Modules\User\Entities\User;

class ProspectController extends Controller
{
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
        $users = User::all();
        $activeUser = [];
        foreach ($users as $user) {
            if (! $user->isActiveEmployee) {
                continue;
            }
            $activeUser[] = $user;
        }

        return view('prospect::create', [
            'users' => $activeUser,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(ProspectRequest $request)
    {
        $prospect = new Prospect();
        $validated = $request->validated();
        $prospect->organization_name = $validated['org_name'];
        $prospect->poc_user_id = $validated['poc_user_id'];
        $prospect->proposal_sent_date = $validated['proposal_sent_date'];
        $prospect->domain = $validated['domain'];
        $prospect->customer_type = $validated['customer_type'];
        $prospect->budget = $validated['budget'];
        $prospect->proposal_status = $validated['proposal_status'];
        $prospect->introductory_call = $validated['proposal_sent_date'];
        $prospect->last_followup_date = $validated['proposal_sent_date'];
        $prospect->rfp_link = $validated['rfp_url'];
        $prospect->proposal_link = $validated['proposal_url'];
        $prospect->save();

        return redirect()->route('prospect.index')->with('status', 'Prospect created successfully!');
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
        $users = User::all();
        $activeUser = [];
        foreach ($users as $user) {
            if (! $user->isActiveEmployee) {
                continue;
            }
            $activeUser[] = $user;
        }
        return view('prospect::edit', [
            'prospect' => $prospect,
            'users' => $activeUser,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        $prospect = Prospect::find($id);
        $prospect->organization_name = $request->org_name;
        $prospect->poc_user_id = $request->poc_user_id;
        $prospect->proposal_sent_date = $request->proposal_sent_date;
        $prospect->domain = $request->domain;
        $prospect->customer_type = $request->customer_type;
        $prospect->budget = $request->budget;
        $prospect->proposal_status = $request->proposal_status;
        $prospect->introductory_call = $request->introductory_call;
        $prospect->last_followup_date = $request->last_followup_date;
        $prospect->rfp_link = $request->rfp_link;
        $prospect->proposal_link = $request->proposal_link;
        $prospect->save();

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
