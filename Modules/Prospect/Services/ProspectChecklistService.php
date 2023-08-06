<?php

namespace Modules\Prospect\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Modules\LegalDocument\Emails\NDA\SendToApprover;
use Modules\LegalDocument\Entities\LegalDocumentMailTemplate;
use Modules\LegalDocument\Entities\LegalDocumentTemplate;
use Modules\ModuleChecklist\Entities\ModuleChecklist;
use Modules\ModuleChecklist\Entities\NDAMeta;
use Modules\Prospect\Contracts\ProspectChecklistServiceContract;
use Modules\Prospect\Entities\Prospect;
use Modules\Prospect\Entities\ProspectChecklistStatus;
use Modules\Prospect\Events\NewProspectHistoryEvent;
use Modules\User\Entities\User;

class ProspectChecklistService implements ProspectChecklistServiceContract
{
    public function show($prospectID, $checklistID)
    {
        $prospect = Prospect::find($prospectID);

        return [
            'prospect' => $prospect,
            'checklistId' => $checklistID,
            'templates' => LegalDocumentTemplate::all(),
            'metaData' => $this->getMetaData($prospect, $checklistID),
        ];
    }

    public function updateChecklist($data, $prospectID, $checklistID)
    {
        $moduleChecklist = ModuleChecklist::find($checklistID);
        $prospect = Prospect::find($prospectID);
        switch ($moduleChecklist->slug) {
            case 'nda':
                $this->handleNDAAgreement($data, $prospect, $moduleChecklist);
                break;
        }

        return [
            'prospect' => $prospect,
        ];
    }

    private function handleNDAAgreement($data, $prospect, $moduleChecklist)
    {
        $action = $data['_action'];

        if ($action == 'initiate') {
            return $this->handleNDAInitiateAction($data, $prospect, $moduleChecklist);
        }

        if ($action == 'approve-nda') {
            return $this->handleNDAReviewAction($data, $prospect, $moduleChecklist);
        }

        if ($action == 'received-nda-from-client') {
            return $this->handleNDAReceiveFromClientAction($data, $prospect, $moduleChecklist);
        }
    }

    private function handleNDAInitiateAction($data, $prospect, $moduleChecklist)
    {
        // Save NDA Meta Data
        $checklistTaskId = $data['checklist_task_id'];
        $ndaMeta = $prospect->ndaMeta->first() ?: new NDAMeta();
        $ndaMeta->status = 'in-review';
        $ndaMeta->approver_id = $data['reviewer_id'];
        $ndaMeta->authoriser_id = $data['authorizer_id'];
        $ndaMeta->mail_template_id = $data['mail_template_id'];
        $ndaMeta->nda_template_id = $data['nda_template_id'];
        $ndaMeta->nda_contact_persons = json_encode($data['nda_contact_persons'], 1);
        $ndaMeta->due_date = $data['due_date'];
        $ndaMeta->enable_reminder = $data['should_send_reminder'];
        $ndaMeta->save();

        $approver = User::find($ndaMeta->approver_id);

        $prospect->ndaMeta()->sync([$ndaMeta->id]);
        ProspectChecklistStatus::markCompleted($prospect, $moduleChecklist->id, $checklistTaskId);
        Mail::send(new SendToApprover($approver, LegalDocumentMailTemplate::first()));
        event(new NewProspectHistoryEvent($prospect, ['description' => 'NDA Initiated. Waiting for review now']));
    }

    private function handleNDAReviewAction($data, $prospect, $moduleChecklist)
    {
        $ndaMeta = $prospect->ndaMeta->first();
        $checklistTaskId = $data['checklist_task_id'];
        $ndaMeta->status = 'review-approved';
        $ndaMeta->save();

        ProspectChecklistStatus::markCompleted($prospect, $moduleChecklist->id, $checklistTaskId);
        event(new NewProspectHistoryEvent($prospect, ['description' => 'NDA Sent to client. Waiting for signed copy.']));
    }

    private function getMetaData($prospect, $checkListID)
    {
        if ($checkListID == 2) {
            return $prospect->ndaMeta->first() ?: new NDAMeta();
        }
    }

    private function handleNDAReceiveFromClientAction($data, $prospect, $moduleChecklist)
    {
        $document = $data['signed_nda_file'];
        $fileName = $prospect->id . '-' . $document->getClientOriginalName();
        $file = Storage::putFileAs('/prospect/nda', $document, $fileName, ['visibility' => 'public']);

        $ndaMeta = $prospect->ndaMeta->first();
        $checklistTaskId = $data['checklist_task_id'];
        $ndaMeta->status = 'received-signed-copy';
        $ndaMeta->signed_copy_file = $file;
        $ndaMeta->save();
        ProspectChecklistStatus::markCompleted($prospect, $moduleChecklist->id, $checklistTaskId);
        event(new NewProspectHistoryEvent($prospect, ['description' => 'Received signed copy from client.']));
    }
}
