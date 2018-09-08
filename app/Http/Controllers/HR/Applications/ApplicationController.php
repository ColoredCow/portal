<?php

namespace App\Http\Controllers\HR\Applications;

use App\Helpers\ContentHelper;
use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\HR\ApplicationRequest;
use App\Http\Requests\HR\CustomApplicationMailRequest;
use App\Mail\HR\Application\CustomApplicationMail;
use App\Mail\HR\Application\JobChanged;
use App\Mail\HR\Application\RoundNotConducted;
use App\Models\HR\Application;
use App\Models\HR\ApplicationMeta;
use App\Models\HR\Job;
use App\Models\Setting;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use PDF;

abstract class ApplicationController extends Controller
{
    abstract public function getApplicationType();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = [
            'status' => request()->get('status') ?: 'non-rejected',
            'job-type' => $this->getApplicationType(),
            'job' => request()->get('hr_job_id'),
            'name' => request()->get('search'),
        ];
        $applications = Application::with(['applicant', 'job'])
            ->applyFilter($filters)
            ->latest()
            ->paginate(config('constants.pagination_size'))
            ->appends(Input::except('page'));

        $countFilters = array_except($filters, ['status']);
        $attr = [
            'applications' => $applications,
            'status' => request()->get('status'),
        ];
        $strings = array_pluck(config('constants.hr.status'), 'label');
        foreach ($strings as $string) {
            $attr[camel_case($string) . 'ApplicationsCount'] = Application::applyFilter($countFilters)
                ->where('status', $string)
                ->get()
                ->count();
        }
        return view('hr.application.index')->with($attr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  String  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $application = Application::findOrFail($id);

        $application->load(['evaluations', 'evaluations.evaluationParameter', 'evaluations.evaluationOption', 'job', 'job.rounds', 'job.rounds.evaluationParameters', 'job.rounds.evaluationParameters.options', 'applicant', 'applicant.applications', 'applicationRounds', 'applicationRounds.evaluations', 'applicationRounds.round', 'applicationMeta']);

        $job = $application->job;
        $approveMailTemplete = Setting::getApprovedEmail();
        $attr = [
            'applicant' => $application->applicant,
            'application' => $application,
            'timeline' => $application->applicant->timeline(),
            'interviewers' => User::interviewers()->get(),
            'applicantOpenApplications' => $application->applicant->openApplications(),
            'applicationFormDetails' => $application->applicationMeta()->formData()->first(),
            'offer_letter' => $application->offer_letter,
            'approveMailTemplete' => $approveMailTemplete,
            'settings' => [
                'noShow' => Setting::getNoShowEmail(),
            ],
            'type' => config("constants.hr.opportunities.$job->type.type"),
        ];

        if ($job->type == 'job') {
            $attr['hasGraduated'] = $application->applicant->hasGraduated();
            $attr['internships'] = Job::isInternship()->latest()->get();
        }
        return view('hr.application.edit')->with($attr);
    }

    public static function generateOfferLetter($id, $redirect = true)
    {
        $application = Application::findOrFail($id);
        $job = $application->job;
        $applicant = $application->applicant;
        $pdf = PDF::loadView('hr.application.offerletter', compact('applicant', 'job'));
        $fileName = FileHelper::getOfferLetterFileName($pdf, $applicant);
        $full_path = storage_path('app/' . config('constants.hr.offer-letters-dir') . '/' . $fileName);
        $pdf->save($full_path);
        $application->saveOfferLetter(config('constants.hr.offer-letters-dir') . '/' . $fileName);
        if ($redirect) {
            return redirect(route('applications.job.edit', $application->id));
        }
        return $application->offer_letter;
    }
    /**
     * Update the specified resource
     *
     * @param ApplicationRequest $request
     * @param integer $id
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
                break;
            case config('constants.hr.application-meta.keys.no-show'):
                $roundNotConductedMeta = ApplicationMeta::create([
                    'hr_application_id' => $application->id,
                    'key' => $validated['action'],
                    'value' => json_encode([
                        'round' => $validated['application_round_id'],
                        'reason' => $validated['no_show_reason'],
                        'user' => Auth::id(),
                        'mail_subject' => $validated['no_show_mail_subject'],
                        'mail_body' => $validated['no_show_mail_body'],
                    ]),
                ]);
                Mail::send(new RoundNotConducted($application, $roundNotConductedMeta));
                return redirect()->back()->with('status', 'Application updated successfully!');
                break;
        }

        return redirect()->back()->with('No changes were done to the application. Please make sure your are submitting valid data.');
    }

    public function sendApplicationMail(CustomApplicationMailRequest $mailRequest, Application $application)
    {
        $validated = $mailRequest->validated();

        $mailDetails = [
            'action' => ContentHelper::editorFormat($validated['mail_action']),
            'mail_subject' => ContentHelper::editorFormat($validated['mail_subject']),
            'mail_body' => ContentHelper::editorFormat($validated['mail_body']),
            'mail_triggered_by' => Auth::id(),
        ];

        ApplicationMeta::create([
            'hr_application_id' => $application->id,
            'key' => config('constants.hr.application-meta.keys.custom-mail'),
            'value' => json_encode($mailDetails),
        ]);

        Mail::send(new CustomApplicationMail($application, $mailDetails['mail_subject'], $mailDetails['mail_body']));

        $status = "Mail sent successfully to <b>" . $application->applicant->name . "</b> at <b>" . $application->applicant->email . "</b>.<br>";

        return redirect()->back()
            ->with('status', $status);
    }

    public function downloadOfferLetter(Application $application)
    {
        $inline = true;

        if (!Storage::exists($application->offer_letter)) {
            return false;
        }

        if ($inline) {
            return Response::make(Storage::get($application->offer_letter), 200, [
                'content-type' => 'application/pdf',
            ]);
        }

        return Storage::download($application->offer_letter);
    }
}
