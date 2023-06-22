<?php

namespace Modules\HR\Services;

use App\Models\Tag;
use Carbon\Carbon;
use Module;
use Modules\HR\Contracts\ApplicationServiceContract;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\Job;
use Modules\HR\Events\CustomMailTriggeredForApplication;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

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

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type'=>'application/json'
        ])
        ->withToken($token)
        ->post($url, [
            'name' => $name,
            'email' =>  $parameters['email'],
            'phone' => $parameters['phone'],
            'subscription_lists' => $subscriptionLists,
        ]);

        $jsonData = $response->json();
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

        return  $accessToken;
    }
}
