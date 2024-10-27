<?php

namespace Modules\Prospect\Services;

use Modules\Prospect\Entities\Prospect;
use Modules\Prospect\Entities\ProspectComment;
use Modules\Prospect\Entities\ProspectInsight;

class ProspectService
{
    public function store($validated)
    {
        $prospect = new Prospect();
        $this->saveProspectData($prospect, $validated);
    }

    public function update($request, $prospect)
    {
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
        $prospect->currency = $request->currency;
        $prospect->save();

        return redirect()->route('prospect.show', $prospect->id)->with('status', 'Prospect updated successfully!');
    }

    public function commentUpdate($validated, $id)
    {
        $prospectComment = new ProspectComment();
        $prospectComment->prospect_id = $id;
        $prospectComment->user_id = auth()->user()->id;
        $prospectComment->comment = $validated['prospect_comment'];
        $prospectComment->save();

        return $prospectComment;
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
        $prospect->rfp_link = $validated['rfp_link'];
        $prospect->proposal_link = $validated['proposal_link'];
        $prospect->currency = $validated['currency'];
        $prospect->save();
    }

    public function insightsUpdate($validated, $id)
    {
        $prospectInsights = new ProspectInsight();
        $prospectInsights->prospect_id = $id;
        $prospectInsights->user_id = auth()->user()->id;
        $prospectInsights->insight_learning = $validated['insight_learning'];
        $prospectInsights->save();
    }
}
