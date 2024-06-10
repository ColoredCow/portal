<?php if ( $todayInterviews ) : ?>
	<?php foreach ( $todayInterviews as $key => $todayInterview ) : ?>
		<div class="w-full">
			<div class="d-flex justify-content-start align-items-center shadow-lg w-full py-2 px-3 mb-5 min-h-70" data-counter>
				<div class="d-flex justify-content-start align-items-center fz-xl-14 text-white">
					<div class="w-150 fz-18 text-start mr-5">
						<a class="text-decoration-none" href="{{ $todayInterview['scheduled_person']['id'] === auth()->id() ? route('applications.job.edit', $todayInterview['application']->id) : route('hr.applicant.details.show', ['applicationID' => $todayInterview['application']->id]) }}">
							<span class="card-title">{{ $todayInterview['application']->applicant->name }}</span>
						</a>
					</div>
					<div class="w-200 fz-18 text-left mr-5">
						<a target="_blank"
							class="font-muli-bold text-decoration-none"
							href="{{ $todayInterview['meeting_link']->hangout_link }}">
							<p class="{{! $todayInterview['meeting_date'] ? 'd-none' : ''}} text-dark mb-1 fz-14"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;{{ $todayInterview['meeting_date'] ? $todayInterview['meeting_date'] : ''}}</p>
							<span><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;{{ $todayInterview['meeting_time'] }}</span>
						</a>
					</div>
					<div class="w-200 text-center mr-5">
						<span class="fz-12 badge badge-pill bg-theme-green interview-job-filter c-pointer" data-id="{{ $todayInterview['application']->job->id }}" value="{{ $todayInterview['application']->job->title }}">{{ $todayInterview['application']->job->title }}</span>
					</div>
					<div class="w-200 text-center mr-5">
					<span class="fz-12 badge badge-pill bg-success interview-round-filter c-pointer" data-id="{{ $todayInterview['round']->id }}" value="{{ $todayInterview['round']->name }}">
					{{ $todayInterview['round']->isTrialRound() ? optional($todayInterview['round']->trialRound)->name : $todayInterview['round']->name }}</span>
					</div>
					<div class="w-100 text-center text-white">
						<span class="fz-12 badge badge-pill bg-secondary interview-opportunity-filter c-pointer" data-id="{{ $todayInterview['application']->job->opportunity_id }}" value="{{ $todayInterview['application']->job->type }}">{{ ucfirst($todayInterview['application']->job->type) }}</span>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	<div class="d-flex justify-content-between align-items-center">
		<div class="pagination-wrapper">
			<nav class="pagination-links">
				{!! $pagination !!}
			</nav>
		</div>
		<div class="interview-loader d-none btn btn-primary">
			<span class="rounded-lg text-center py-1 px-2">Loading...</span>
		</div>
	</div>
	<?php else : ?>
		<div class="d-flex justify-content-center mt-20 w-full">
			<div class="fz-36">
				<p>No Upcoming meetings for Today</p>
			</div>
		</div>
<?php endif; ?>
