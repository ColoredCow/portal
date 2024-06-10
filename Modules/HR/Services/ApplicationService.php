<?php

namespace Modules\HR\Services;

use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Module;
use Modules\HR\Contracts\ApplicationServiceContract;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Entities\Job;
use Modules\HR\Events\CustomMailTriggeredForApplication;
use Modules\User\Entities\User;

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

        Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type'=>'application/json',
        ])
        ->withToken($token)
        ->post($url, [
            'name' => $name,
            'email' =>  $parameters['email'],
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
	
		public function getApplicationsForDate($today, $selectedOperator, $searchCategory, $selectedJob, $selectedOpportunity, $selectedRound)
		{
			$totalOpportunitiesCount = Job::where('status', 'published')->count();
			$todayApplications       = Application::whereDate('created_at', $today)->get();
			$interviewApplicationsQuery = ApplicationRound::whereNotNull('calendar_meeting_id')
				// ->whereNull('conducted_date')
				// ->where('scheduled_person_id', auth()->id())
				->with('application.applicant', 'application.job', 'round', 'meetingLink', 'scheduledPerson')
				->orderByRaw('hr_application_round.scheduled_date ASC');

			if ($selectedOperator !== null) {
				$interviewApplicationsQuery->whereDate('scheduled_date', $selectedOperator, $today);
			} else {
				$interviewApplicationsQuery->whereDate('scheduled_date', $today);
			}
			if ($selectedJob !== null) {
				$interviewApplicationsQuery->whereHas('application.job', function ($query) use ($selectedJob) {
					$query->where('id', $selectedJob);
				});
			}
			if ($selectedOpportunity !== null) {
				$interviewApplicationsQuery->whereHas('application.job', function ($query) use ($selectedOpportunity) {
					$query->where('opportunity_id', $selectedOpportunity);
				});
			}
			if ($selectedRound !== null) {
				$interviewApplicationsQuery->where('hr_round_id', $selectedRound);
			}
			if ($searchCategory !== null) {
				$interviewApplicationsQuery->where(function ($query) use ($searchCategory) {
					$query->whereHas('application.applicant', function ($query) use ($searchCategory) {
						$query->where('name', 'LIKE', "%{$searchCategory}%");
					})->orWhereHas('application.job', function ($query) use ($searchCategory) {
						$query->where('title', 'LIKE', "%{$searchCategory}%");
					})->orWhereHas('round', function ($query) use ($searchCategory) {
						$query->where('name', 'LIKE', "%{$searchCategory}%");
					});
				});
			}
			$interviewApplications = $interviewApplicationsQuery->paginate(config('constants.pagination_size'));

			// Process today's applications
			$totalTodayApplication = $todayApplications->groupBy( 'job.id' )
				->mapWithKeys(
					function ( $applications, $jobId ) {
						$jobName = $applications->first()->job->title;
						return array( $jobName => $applications->count() );
					}
				);

			$todayInterviews = array();
			$applicationType = array();
			foreach ( $interviewApplications as $interviewApplication ) {
				$application = $interviewApplication->application;
				$job         = $application->job;
				$round       = $interviewApplication->round;

				$meetingStart = $interviewApplication->scheduled_date->format( config( 'constants.display_time_format' ) );
				$meetingEnd   = Carbon::parse( $interviewApplication->scheduled_end )->format( config( 'constants.display_time_format' ) );
				$meetingTime  = $meetingStart . '-' . $meetingEnd;
				$meetingDate  = Carbon::parse( $interviewApplication->scheduled_date )->format( config( 'constants.full_display_date_format' ) );

				$todayInterviews[] = array(
					'application'      => $application,
					'round'            => $round,
					'meeting_link'     => $interviewApplication->meetingLink,
					'scheduled_person' => array(
						'id'   => $interviewApplication->scheduled_person_id,
						'name' => $interviewApplication->scheduledPerson->name,
					),
					'meeting_time'     => $meetingTime,
					'meeting_date'     => $selectedOperator !== null ? $meetingDate : null,
				);

				$jobType  = $job->type;
				$jobTitle = $job->title;
				$jobId    = $job->id;

				if ( ! isset( $applicationType[ $jobType ] ) ) {
					$applicationType[ $jobType ] = array();
				}

				if ( ! isset( $applicationType[ $jobType ][ $jobTitle ] ) ) {
					$applicationType[ $jobType ][ $jobTitle ] = array();
				}

				if ( ! isset( $applicationType[ $jobType ][ $jobTitle ][ $jobId ] ) ) {
					$applicationType[ $jobType ][ $jobTitle ][ $jobId ] = 0;
				}

				++$applicationType[ $jobType ][ $jobTitle ][ $jobId ];
			}

			return array(
				'todayInterviews'       => $todayInterviews,
				'todayApplications'     => $totalTodayApplication,
				'totalOpportunities'    => $totalOpportunitiesCount,
				'applicationType'       => $applicationType,
				'pagination'            => $interviewApplications->links(),
			);
		}
}
