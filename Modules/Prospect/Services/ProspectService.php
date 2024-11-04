<?php

namespace Modules\Prospect\Services;

use Modules\Client\Entities\Country;
use Modules\Prospect\Entities\Prospect;
use Modules\Prospect\Entities\ProspectComment;
use Modules\Prospect\Entities\ProspectInsight;

class ProspectService
{
    public function index(array $requestData = [])
    {
        return [
            'prospects' => $this->getFilteredProspects($requestData),
            'currencySymbols' => $this->getCurrencySymbols(),
        ];
    }

    public function store($validated)
    {
        $prospect = new Prospect();
        $this->saveProspectData($prospect, $validated);
    }

    public function update($request, $prospect)
    {
        $budget = $request->budget ?? null;
        $prospect->organization_name = $request->org_name;
        $prospect->poc_user_id = $request->poc_user_id;
        $prospect->proposal_sent_date = $request->proposal_sent_date;
        $prospect->domain = $request->domain;
        $prospect->customer_type = $request->customer_type;
        $prospect->budget = $budget;
        $prospect->proposal_status = $request->proposal_status;
        $prospect->introductory_call = $request->introductory_call;
        $prospect->last_followup_date = $request->last_followup_date;
        $prospect->rfp_link = $request->rfp_link;
        $prospect->proposal_link = $request->proposal_link;
        $prospect->currency = $budget ? $request->currency : null;
        $prospect->client_id = $request->client_id ?? null;
        $prospect->project_name = $request->project_name;
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

    public function insightsUpdate($validated, $id)
    {
        $prospectInsights = new ProspectInsight();
        $prospectInsights->prospect_id = $id;
        $prospectInsights->user_id = auth()->user()->id;
        $prospectInsights->insight_learning = $validated['insight_learning'];
        $prospectInsights->save();
    }

    private function getFilteredProspects(array $requestData = [])
    {
        $filter = $requestData['status'] ?? 'open';

        return Prospect::query()->when(
            $filter === 'open',
            fn ($query) => $query->where(function ($query) {
                $query->whereNotIn('proposal_status', ['rejected', 'converted'])
                    ->orWhereNull('proposal_status')
                    ->orWhere('proposal_status', '');
            }),
            fn ($query) => $query->where('proposal_status', $filter)
        )
        ->orderBy('created_at', 'desc')
        ->paginate(config('constants.pagination_size'))
        ->appends($requestData);
    }

    private function getCurrencySymbols()
    {
        return Country::pluck('currency_symbol', 'currency');
    }

    private function saveProspectData($prospect, $validated)
    {
        $budget = $validated['budget'] ?? null;
        $prospect->organization_name = $validated['org_name'];
        $prospect->poc_user_id = $validated['poc_user_id'];
        $prospect->proposal_sent_date = $validated['proposal_sent_date'] ?? null;
        $prospect->domain = $validated['domain'] ?? null;
        $prospect->customer_type = $validated['customer_type'] ?? null;
        $prospect->budget = $budget;
        $prospect->proposal_status = $validated['proposal_status'] ?? null;
        $prospect->introductory_call = $validated['introductory_call'] ?? null;
        $prospect->last_followup_date = $validated['last_followup_date'] ?? null;
        $prospect->rfp_link = $validated['rfp_link'] ?? null;
        $prospect->proposal_link = $validated['proposal_link'] ?? null;
        $prospect->client_id = $validated['client_id'] ?? null;
        $prospect->currency = $budget ? $validated['currency'] : null;
        $prospect->project_name = $validated['project_name'] ?? null;
        $prospect->save();
    }
}
