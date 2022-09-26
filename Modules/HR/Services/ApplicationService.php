<?php

namespace Modules\HR\Services;

use Module;
use App\Models\Tag;
use Modules\HR\Entities\Job;
use Modules\User\Entities\User;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Application;
use Modules\HR\Contracts\ApplicationServiceContract;
use Modules\HR\Events\CustomMailTriggeredForApplication;
use Modules\HR\Http\Requests\ApplicantMetaRequest;
use Modules\HR\Entities\ApplicantMeta;

class ApplicationService implements ApplicationServiceContract
{
    public function index($applicationType)
    {
        $filters = [
            'status' => request()->get('status') ?: 'non-rejected',
            'job-type' => $applicationType,
            'job' => request()->get('hr_job_id'),
            'search' => request()->get('search'),
            'tags' => request()->get('tags'),
            'assignee' => request()->get('assignee'), // TODO
            'round' => str_replace('-', ' ', request()->get('round')),
        ];

        $loggedInUserId = auth()->id();
        $applications = Application::join('hr_application_round', function ($join) {
            $join->on('hr_application_round.hr_application_id', '=', 'hr_applications.id')
                ->where('hr_application_round.is_latest', true);
        })
            ->with(['applicant', 'job', 'tags', 'latestApplicationRound'])
            ->whereHas('latestApplicationRound')
            ->applyFilter($filters)
            ->orderByRaw("FIELD(hr_application_round.scheduled_person_id, {$loggedInUserId} ) DESC")
            ->orderByRaw('ISNULL(hr_application_round.scheduled_date) ASC')
            ->orderByRaw('hr_application_round.scheduled_date ASC')
            ->select('hr_applications.*')
            ->latest()
            ->paginate(config('constants.pagination_size'))
            ->appends(request()->except('page'));
        $countFilters = array_except($filters, ['status', 'round']);
        $attr = [
            'applications' => $applications,
            'status' => request()->get('status'),
        ];
        $hrRounds = ['Resume Screening', 'Telephonic Interview', 'Introductory Call', 'Basic Technical Round', 'Detailed Technical Round', 'Team Interaction Round', 'HR Round', 'Trial Program', 'Volunteer Screening'];
        $strings = array_pluck(config('hr.status'), 'label');

        foreach ($strings as $string) {
            $attr[camel_case($string) . 'ApplicationsCount'] = Application::applyFilter($countFilters)
                ->where('status', $string)
                ->whereHas('latestApplicationRound', function ($subQuery) {
                    return $subQuery->where('is_latest', true);
                })
                ->count();
        }

        foreach ($hrRounds as $round) {
            $attr[camel_case($round) . 'Count'] = Application::applyFilter($countFilters)
                ->where('status', config('hr.status.in-progress.label'))
                ->whereHas('latestApplicationRound', function ($subQuery) use ($round) {
                    return $subQuery->where('is_latest', true)
                        ->whereHas('round', function ($subQuery) use ($round) {
                            return $subQuery->where('name', $round);
                        });
                })
                ->count();
        }

        $attr['jobs'] = Job::all();
        $attr['tags'] = Tag::orderBy('name')->get();

        if (Module::has('User')) {
            $attr['assignees'] = User::orderBy('name')->get();
        }

        return $attr;
    }

    public function saveApplication($data)
    {
        $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
        Applicant::_create($data);

        return true;
    }

    public function sendApplicationMail($application, $data)
    {
        // call event that triggers send custom application mail
        $data['mail_sender_name'] = $data['mail_sender_name'] ?? auth()->user()->name;
        event(new CustomMailTriggeredForApplication($application, $data));
    }

    public function store(ApplicantMetaRequest $request)
    {
        $keyConfigs = (config('hr.applicant_form-details'));
        $uploadConfigs = (config('hr.applicant_upload_details'));
        $encryptConfigs = (config('hr.encrypted-applicant-details'));

        foreach ($keyConfigs as $key=>$label) {
            ApplicantMeta::updateOrCreate([
                'hr_applicant_id' => $request->get('hr_applicant_id'),
                'key' => $label,
                'value' => $request->get($key),
            ]);
        }

        foreach ($encryptConfigs as $key=>$label) {
            ApplicantMeta::updateOrInsert(
                [
                'key' => $label,
                'hr_applicant_id' => $request->get('hr_applicant_id'),
            ],
                [
                'hr_applicant_id' => $request->get('hr_applicant_id'),
                'key' => $label,
                'value' => encrypt($request->get($key)),
            ]
            );
        }

        foreach ($uploadConfigs as $key=>$label) {
            if ($request->file($key)) {
                $file = $request->file($key);
                $fileName = $key . $request->get('hr_applicant_id') . '.' . $file->extension();
                $filepath = $file->move(storage_path('app/public/Employee-Documents-Details'), $fileName);
                ApplicantMeta::updateOrInsert(
                    [
                    'key' => $label,
                    'hr_applicant_id' => $request->get('hr_applicant_id'),
                ],
                    [
                    'hr_applicant_id' => $request->get('hr_applicant_id'),
                    'key' => $label,
                    'value' => $fileName,
                ]
                );
            }
        }
    }
}
