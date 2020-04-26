<?php

namespace Modules\Prospect\Services;

use Illuminate\Support\Str;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Auth;
use Modules\Prospect\Entities\Prospect;
use Modules\Prospect\Entities\ProspectStage;
use Modules\Client\Entities\ClientContactPerson;
use Modules\Prospect\Entities\ProspectContactPerson;
use Modules\Prospect\Contracts\ProspectServiceContract;

class ProspectService implements ProspectServiceContract
{
    public function index()
    {
        $prospects = Prospect::all();
        return ['prospects' => Prospect::all(), 'count' => $prospects->count()];
    }

    public function create()
    {
        return ['clientContactPersons' => $this->getAllClientContactPersons(), 'assigneeData' => $this->getAssignee(), ];
    }

    public function edit($prospect, $section)
    {
        return [
            'prospect' => $prospect,
            'section' => $section ?? 'prospect-details',
            'contactPersons' => $prospect->contactPersons,
            'clientContactPersons' => $this->getAllClientContactPersons(),
            'assigneeData' => $this->getAssignee()
        ];
    }

    public function store($data)
    {
        $data['created_by'] = Auth::id();
        return Prospect::create($data);
    }

    public function show($prospectId, $section)
    {
        $prospect = Prospect::where('id', $prospectId)
            ->with('histories')
            ->first();
        return [
            'prospect' => $prospect,
            'section' => $section ?: config('prospect.default-prospect-show-tab'),
            'prospectStages' => ProspectStage::orderBy('name')->get(),
        ];
    }

    public function update($data, $prospectID)
    {
        $data['section'] = $data['section'] ?? null;
        $section = $data['section'];
        $nextStage = route('prospect.index');
        $defaultRoute = route('prospect.index');
        $prospect = Prospect::find($prospectID);

        switch ($section) {
            case 'prospect-details':
                $this->updateProspectDetails($data, $prospect);
                $nextStage = route('prospect.edit', [$prospect, 'contact-persons']);
            break;
            case 'contact-persons':
                $this->updateProspectContactPersons($data, $prospect);
               // $nextStage = route('client.edit', [$prospect, 'contact-persons']);
            break;
        }

        return [
            'route' => ($data['submit_action'] == 'next') ? $nextStage : $defaultRoute
        ];
    }

    private function getAssignee()
    {
        return User::orderBy('name')->get();
    }

    private function updateProspectContactPersons($data, $prospect)
    {
        $contactPersons = $data['prospect_contact_persons'] ?? [];
        $prospectContactPersons = collect([]);
        foreach ($contactPersons as $contactPersonData) {
            $contactPersonID = $contactPersonData['id'] ?? null;
            if ($contactPersonID) {
                $contactPerson = ProspectContactPerson::find($contactPersonID);
                $contactPerson->update($contactPersonData);
                $prospectContactPersons->push($contactPerson);
                continue;
            }
            $contactPerson = new ProspectContactPerson($contactPersonData);
            $prospect->contactPersons()->save($contactPerson);
            $prospectContactPersons->push($contactPerson);
        }

        $prospect->contactPersons
            ->diff($prospectContactPersons)
            ->each(function ($contactPerson) {
                $contactPerson->delete();
            });
        return true;
    }

    private function updateProspectDetails($data, $prospect)
    {
        return $prospect->update($data);
    }

    private function getAllClientContactPersons()
    {
        return ClientContactPerson::with('client')->orderBy('name')->get();
    }

    public function addNewProgressStage($data)
    {
        $stageName = $data['stageName'] ?? '';
        $stageName = trim($stageName);

        if (!$stageName) {
            return false;
        }

        $prospectStage = ProspectStage::firstOrNew(['name' => $stageName]);
        $prospectStage->created_by = Auth::id();
        $prospectStage->slug = Str::slug($stageName);
        $prospectStage->save();
        return $prospectStage;
    }
}
