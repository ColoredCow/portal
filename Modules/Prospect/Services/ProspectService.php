<?php

namespace Modules\Prospect\Services;

use Modules\Prospect\Entities\Prospect;
use Modules\Prospect\Entities\ProspectComment;

class ProspectService
{
    public function store($validated)
    {
        $prospect = new Prospect();
        $this->saveProspectData($prospect, $validated);

        return redirect()->route('prospect.index')->with('status', 'Prospect created successfully!');
    }

    public function update($request, $id)
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
        $prospect->last_followup_date = $request->introductory_call;
        $prospect->rfp_link = $request->introductory_call;
        $prospect->proposal_link = $request->proposal_link;
        $prospect->save();

        return redirect()->route('prospect.index')->with('status', 'Prospect updated successfully!');
    }

    private function saveProspectData($prospect, $validated)
    {
        $prospect->organization_name = $validated['org_name'];
        $prospect->poc_user_id = $validated['poc_user_id'];
        $prospect->proposal_sent_date = $validated['proposal_sent_date'];
        $prospect->domain = $validated['domain'];
        $prospect->customer_type = $validated['customer_type'];
        $prospect->budget = $validated['budget'];
        $prospect->proposal_status = $validated['proposal_status'];
        $prospect->introductory_call = $validated['introductory_call'] ?? $validated['proposal_sent_date'];
        $prospect->last_followup_date = $validated['last_followup_date'] ?? $validated['proposal_sent_date'];
        $prospect->rfp_link = $validated['rfp_link'] ?? $validated['rfp_url'];
        $prospect->proposal_link = $validated['proposal_link'] ?? $validated['proposal_url'];
        $prospect->save();
    }

    public function commentUpdate($request, $id)
    {
        $prospect = new ProspectComment();
        $prospect->prospect_id = $id;
        $prospect->user_id = auth()->user()->id;
        $prospect->comment = $request->prospect_comment;
        $prospect->save();

        return $prospect;
    }
}
