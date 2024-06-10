<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use App\Helpers\FileHelper;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Modules\HR\Emails\Recruitment\Application\ApplicationHandover;
use Modules\HR\Emails\Recruitment\Application\JobChanged;
use Modules\HR\Emails\Recruitment\Application\RoundNotConducted;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationMeta;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Http\Requests\Recruitment\ApplicationRequest;
use Modules\HR\Http\Requests\Recruitment\CustomApplicationMailRequest;
use Modules\HR\Http\Requests\TeamInteractionRequest;
use Modules\HR\Services\ApplicationService;
use Modules\User\Entities\User;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

abstract class ApplicationController extends Controller
{
    protected $service;

    public function __construct(ApplicationService $service)
    {
        $this->service = $service;
    }
    abstract public function getApplicationType();

    public function markInterviewFinished(Request $request)
    {
        $ApplicationRound = ApplicationRound::find($request->documentId);
        $this->service->markInterviewFinished($ApplicationRound);

        return response()->json([
            'status' => 200, 'actual_end_time' => $ApplicationRound->actual_end_time->format('H:i:s'), 'html' => view('hr.application.meeting-duration')->with(['applicationRound' => $ApplicationRound])->render(),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applicationType = $this->getApplicationType();

        $attr = $this->service->index($applicationType);

        return view('hr.application.index')->with($attr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     */
    public function edit($id)
    {
        $application = Application::findOrFail($id);

        $attr = $this->service->edit($application);

        return view('hr.application.edit')->with($attr);
    }

    public function generateTeamInteractionEmail(TeamInteractionRequest $request)
    {
        $subject = Setting::where('module', 'hr')->where('setting_key', 'hr_team_interaction_round_subject')->first();
        $body = Setting::where('module', 'hr')->where('setting_key', 'hr_team_interaction_round_body')->first();
        $body->setting_value = str_replace('|*OFFICE LOCATION*|', $request->location, $body->setting_value);
        $body->setting_value = str_replace('|*DATE SELECTED*|', date('d M Y', strtotime($request->date)), $body->setting_value);
        $body->setting_value = str_replace('|*TIME*|', date('h:i a', strtotime($request->timing)), $body->setting_value);
        $body->setting_value = str_replace('|*APPLICANT NAME*|', $request->applicant_name, $body->setting_value);

        return response()->json([
            'subject' => $subject->setting_value,
            'body' => $body->setting_value,
        ]);
    }

    public function generateOnHoldEmail(Request $request)
    {
        $subject = Setting::where('module', 'hr')->where('setting_key', $request->setting_key_subject)->first();
        $body = Setting::where('module', 'hr')->where('setting_key', $request->setting_key_body)->first();
        $body->setting_value = str_replace('|*applicant_name*|', $request->applicant_name, $body->setting_value);
        $body->setting_value = str_replace('|*job_title*|', $request->job_title, $body->setting_value);

        return response()->json([
            'subject' => $subject->setting_value,
            'body' => $body->setting_value,
        ]);
    }

    public function saveOfferLetter(Application $application)
    {
        $offer_letter_body = Setting::getOfferLetterTemplate()['body'];
        $job = $application->job;
        $applicant = $application->applicant;
        $pdf = Pdf::loadView('hr.application.draft-joining-letter', compact('applicant', 'job', 'offer_letter_body'));
        $fileName = FileHelper::getOfferLetterFileName($applicant, $pdf);
        $directory = 'app/public/' . config('constants.hr.offer-letters-dir');
        if (! is_dir(storage_path($directory)) && ! file_exists(storage_path($directory))) {
            mkdir(storage_path($directory), 0, true);
        }
        $fullPath = storage_path($directory . '/' . $fileName);
        $pdf->save($fullPath);
    }

    public static function getOfferLetter(Application $application)
    {
        $pdf = FileHelper::generateOfferLetter($application, true);

        return response()->json([
            'pdf' => $pdf,
        ]);
    }

    /**
     * Update the specified resource.
     *
     * @param ApplicationRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ApplicationRequest $request, int $id)
    {
        $validated = $request->validated();
        $application = Application::findOrFail($id);
        $application->load('applicant');

        switch ($validated['action']) {
            case config('constants.hr.application-meta.keys.change-job'):
                $changeJobMeta = $application->changeJob($validated);
                Mail::send(new JobChanged($application, $changeJobMeta));

                return redirect()->route('applications.internship.edit', $id)->with('status', 'Application updated successfully!');
            case config('constants.hr.application-meta.keys.no-show'):
                $roundNotConductedMeta = ApplicationMeta::create([
                    'hr_application_id' => $application->id,
                    'key' => $validated['action'],
                    'value' => json_encode([
                        'round' => $validated['application_round_id'],
                        'reason' => $validated['no_show_reason'],
                        'user' => auth()->id(),
                        'mail_subject' => $validated['no_show_mail_subject'],
                        'mail_body' => $validated['no_show_mail_body'],
                    ]),
                ]);
                Mail::send(new RoundNotConducted($application, $roundNotConductedMeta));

                return redirect()->back()->with('status', 'Application updated successfully!');
        }

        return redirect()->back()->with('No changes were done to the application. Please make sure your are submitting valid data.');
    }

    public function sendApplicationMail(CustomApplicationMailRequest $mailRequest, Application $application)
    {
        $validated = $mailRequest->validated();

        $this->service->sendApplicationMail($application, [
            'action' => $validated['mail_action'],
            'mail_subject' => $validated['mail_subject'],
            'mail_body' => $validated['mail_body'],
        ]);

        $status = 'Mail sent successfully to <b>' . $application->applicant->name . '</b> at <b>' . $application->applicant->email . '</b>.<br>';

        return redirect()->back()
            ->with('status', $status);
    }

    public function viewOfferLetter(Application $application)
    {
        if (! Storage::exists($application->offer_letter)) {
            return false;
        }

        return Response::make(Storage::get($application->offer_letter), 200, [
            'content-type' => 'application/pdf',
        ]);
    }

    public function applicationHandoverRequest(Application $application)
    {
        $currentAssignee = $application->latestApplicationRound->scheduledPerson->email;
        $userName = auth()->user()->name;
        Mail::to($currentAssignee)->queue(new ApplicationHandover($application, $userName));

        return redirect()->back()->with('status', 'Your request has successfully been sent');
    }

    public function acceptHandoverRequest(Request $request, Application $application)
    {
        $scheduledPersonId = $request->get('user');

        $applicationRound = $application->latestApplicationRound;
        $applicationRound->update([
            'scheduled_person_id' => $scheduledPersonId,
        ]);
        $scheduledUser = User::where('id', $scheduledPersonId)->first()->name;

        $status = 'Successful Assigned to ' . $scheduledUser;

        return redirect(route('applications.job.index'))->with('status', $status);
    }
}
