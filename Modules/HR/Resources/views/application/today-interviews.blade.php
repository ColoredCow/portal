<?php if ( $todayInterviews ) : ?>
	<?php foreach ( $todayInterviews as $key => $todayInterview ) : ?>
		<div class="w-full">
			<div class="d-flex justify-content-start align-items-center shadow-lg w-full py-2 px-3 mb-5 min-h-50" data-counter>
				<div class="d-flex justify-content-start align-items-center fz-xl-14 text-white font-weight-semibold">
					<div class="w-150 fz-16 text-start mr-5" style="font-weight: 500">
						<a class="text-decoration-none" href="{{ $todayInterview['scheduled_person']['id'] === auth()->id() ? route('applications.job.edit', $todayInterview['application']->id) : route('hr.applicant.details.show', ['applicationID' => $todayInterview['application']->id]) }}">
							<span class="card-title">{{ $todayInterview['application']->applicant->name }}</span>
						</a>
					</div>
					<div class="w-200 fz-18 text-left mr-5">
						<a target="_blank"
							class="font-muli-regular text-decoration-none"
							href="{{ $todayInterview['meeting_link']->hangout_link }}">
							<p class="{{! $todayInterview['meeting_date'] ? 'd-none' : ''}} text-dark mb-1 fz-14"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;{{ $todayInterview['meeting_date'] ? $todayInterview['meeting_date'] : ''}}</p>
							<span><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;{{ $todayInterview['meeting_time'] }}</span>
						</a>
					</div>
					<div class="w-180 text-center mr-5 text-white">
						<span class="fz-12 badge badge-pill bg-primary interview-job-filter c-pointer" data-id="{{ $todayInterview['application']->job->id }}" value="{{ $todayInterview['application']->job->title }}">{{ $todayInterview['application']->job->title }}</span>
					</div>
					<div class="w-180 text-center mr-5 text-white">
					<span class="fz-12 badge badge-pill bg-primary interview-round-filter c-pointer" data-id="{{ $todayInterview['round']->id }}" value="{{ $todayInterview['round']->name }}">
					{{ $todayInterview['round']->isTrialRound() ? optional($todayInterview['round']->trialRound)->name : $todayInterview['round']->name }}</span>
					</div>
					<div class="w-100 text-center text-white mr-3">
						<span class="fz-12 badge badge-pill bg-primary interview-opportunity-filter c-pointer" data-id="{{ $todayInterview['application']->job->type }}" value="{{ $todayInterview['application']->job->type }}">{{ ucfirst($todayInterview['application']->job->type) }}</span>
					</div>
					<?php if(! $todayInterview['meeting_date']) :?>
						<div class="w-120 text-center text-white">
							<button type="button"
								value="{{ $todayInterview['id'] }}"
								class="btn-sm btn-primary text-decoration-none finish_interview font-weight-bold">Finish
								Interview</button>
						</div>
					<?php endif; ?>
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
	</div>
	<?php else : ?>
		<div class="d-flex justify-content-center mt-10 w-full">
			<div class="fz-24 text-center w-full">
				<p>No Upcoming meetings for Today</p>
			</div>
		</div>
<?php endif; ?>
