<?php

namespace Modules\Prospect\Services;
use Modules\Prospect\Entities\Prospect;

class ProspectService
{
    public function store($validated)
    {
        $prospect = new Prospect();
        $this->saveProspectData($prospect, $validated);

        return redirect()->route('prospect.index')->with('status', 'Prospect created successfully!');
    }

    public function update($validated, $id)
    {
        $prospect = Prospect::find($id);
        $this->saveProspectData($prospect, $validated);

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

}
