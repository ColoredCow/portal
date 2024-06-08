<?php

namespace Modules\HR\Services;

use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Modules\HR\Contracts\ApplicationServiceContract;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\ApplicantMeta;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Job;
use Modules\HR\Entities\Round;
use Modules\HR\Entities\University;
use Modules\HR\Events\CustomMailTriggeredForApplication;
use Modules\User\Entities\User;

class ApplicationService implements ApplicationServiceContract
{
    public function index($applicationType)
    {
        $referer = request()->headers->get('referer');

        if (! session()->get('should_skip_page') && Str::endsWith($referer, 'edit')) {
            session()->put(['should_skip_page' => true]);

            return redirect()->route(request()->route()->getName(), session()->get('previous_application_data'))->with('status', session()->get('status'));
        }

        session()->put([
            'previous_application_data' => request()->all(),
            'should_skip_page' => false,
        ]);

        $filters = [
            'status' => request()->get('status') ?: 'non-rejected',
            'job-type' => $applicationType,
            'job' => request()->get('hr_job_id'),
            'university' => request()->get('hr_university_id'),
            'graduation_year' => request()->get('end-year'),
            // 'sortby' => request()->get('sort_by'), Commenting, as we need to brainstorm on this feature a bit
            'search' => request()->get('search'),
            'tags' => request()->get('tags'),
            'assignee' => request()->get('assignee'), // TODO
            'round' => str_replace('-', ' ', request()->get('round')),
            'roundFilters' => request()->get('roundFilters'),
        ];

        $loggedInUserId = auth()->id();
        $applications = Application::select('hr_applications.*')
            ->join('hr_application_round', function ($join) {
                $join->on('hr_application_round.hr_application_id', '=', 'hr_applications.id')
                    ->where('hr_application_round.is_latest', true);
            })
            ->with(['applicant', 'job', 'tags', 'latestApplicationRound'])
            ->whereHas('latestApplicationRound')
            ->applyFilter($filters)
            ->orderByRaw("FIELD(hr_application_round.scheduled_person_id, {$loggedInUserId} ) DESC")
            ->orderByRaw('ISNULL(hr_application_round.scheduled_date) ASC')
            ->orderByRaw('hr_application_round.scheduled_date ASC')
            ->latest()
            ->paginate(config('constants.pagination_size'))
            ->appends(request()->except('page'));
        $countFilters = array_except($filters, ['status', 'round']);
        $attr = [
            'applications' => $applications,
            'status' => request()->get('status'),
        ];
        $hrRounds = ['Resume Screening', 'Telephonic Interview', 'Introductory Call', 'Basic Technical Round', 'Detailed Technical Round', 'Team Interaction Round', 'HR Round', 'Trial Program', 'Volunteer Screening'];
        $strings = array_pluck(config('constants.hr.status'), 'label');
        $hrRoundsCounts = [];
        $strings = array_pluck(config('hr.status'), 'label');

        foreach ($strings as $string) {
            $attr[camel_case($string) . 'ApplicationsCount'] = Application::applyFilter($countFilters)
                ->where('status', $string)
                ->whereHas('latestApplicationRound', function ($subQuery) {
                    return $subQuery->where('is_latest', true);
                })
                ->count();
        }

        $jobType = $applicationType;

        foreach ($hrRounds as $round) {
            $applicationCount = Application::query()->filterByJobType($jobType)
                ->whereIn('hr_applications.status', ['in-progress', 'new', 'trial-program'])
                ->FilterByRoundName($round)
                ->count();
            $hrRoundsCounts[$round] = $applicationCount;
            $attr[camel_case($round) . 'Count'] = Application::applyFilter($countFilters)
                ->where('status', config('constants.hr.status.in-progress.label'))
                ->whereHas('latestApplicationRound', function ($subQuery) use ($round) {
                    return $subQuery->where('is_latest', true)
                        ->whereHas('round', function ($subQuery) use ($round) {
                            return $subQuery->where('name', $round);
                        });
                })
                ->count();
        }

        $attr['jobs'] = Job::all();
        $attr['universities'] = University::all();
        $attr['tags'] = Tag::orderBy('name')->get();
        $attr['rounds'] = $hrRoundsCounts;
        $attr['roundFilters'] = round::orderBy('name')->get();
        $attr['assignees'] = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['super-admin', 'admin', 'hr-manager']);
        })->orderby('name', 'asc')->get();

        $openApplicationCountForJob = Application::whereIn('hr_job_id', $applications->pluck('hr_job_id'))
            ->isOpen()
            ->selectRaw('hr_job_id, COUNT(*) as count')
            ->groupBy('hr_job_id')
            ->get()
            ->keyBy('hr_job_id')
            ->toArray();

        foreach ($applications->items() as $application) {
            $attr['openApplicationsCountForJobs'][$application->job->title] = $openApplicationCountForJob[$application->hr_job_id]['count'] ?? 0;
        }

        $attr['applicantId'] = [];
        $applications = Application::pluck('hr_applicant_id');
        $applicantData = ApplicantMeta::whereIn('hr_applicant_id', $applications)->get();

        foreach ($applicantData as $data) {
            $attr['applicantId'][$data->hr_applicant_id] = $data;
        }

        return $attr;
    }

    public function saveApplication($data, $subscriptionLists)
    {
        try {
            $this->addSubscriberToCampaigns($data, $subscriptionLists);
        } catch (\Exception $e) {
            return redirect(route('applications.job.index'))->with('error', 'Error occurred while sending data to Campaign');
        }

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

    public function markInterviewFinished($data)
    {
        $meetDate = config('timezone');
        $meetDuration = Carbon::parse($meetDate);
        $data->actual_end_time = $meetDuration;
        $data->save();
    }

    public function addSubscriberToCampaigns($parameters, $subscriptionLists)
    {
        $name = $parameters['first_name'] . ' ' . $parameters['last_name'];
        $token = $this->getToken();
        $CAMPAIGNS_TOOL_URL = config('constants.campaign_tool_credentials.url');
        $url = $CAMPAIGNS_TOOL_URL . '/api/v1/addSubscriber';

        // check $subscriptionLists is array or not
        $subscriptionLists = is_array($subscriptionLists) ? $subscriptionLists : [$subscriptionLists];

        Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])
            ->withToken($token)
            ->post($url, [
                'name' => $name,
                'email' => $parameters['email'],
                'phone' => $parameters['phone'],
                'subscription_lists' => $subscriptionLists,
            ]);
    }

    public function getToken()
    {
        $savedToken = Cache::get('campaign_token');
        if ($savedToken) {
            return $savedToken;
        }

        $CAMPAIGNS_TOOL_URL = config('constants.campaign_tool_credentials.url');
        $url = $CAMPAIGNS_TOOL_URL . '/oauth/token';
        $response = Http::asForm()->post($url, [
            'grant_type' => 'client_credentials',
            'client_id' => config('constants.campaign_tool_credentials.client_id'),
            'client_secret' => config('constants.campaign_tool_credentials.client_secret'),
        ]);

        $accessToken = $response->json()['access_token'];
        // Store the token in the cache for 1 day.
        Cache::put('campaign_token', $accessToken, 60 * 24);

        return $accessToken;
    }
}
