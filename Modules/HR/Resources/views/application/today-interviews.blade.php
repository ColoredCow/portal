<?php foreach ( $todayInterviews as $key => $todayInterview ) : ?>
<div class="w-full" data-counter>
	<div class="d-flex justify-content-start align-items-center shadow-lg w-full py-2 px-3 mb-5 min-h-70">
		<div class="d-flex justify-content-start align-items-center fz-xl-14 text-white">
			<div class="w-150 fz-18 text-start mr-5">
				<a class="text-decoration-none" href="{{ $todayInterview['scheduled_person']['id'] === auth()->id() ? route('applications.job.edit', $todayInterview['application']->id) : route('hr.applicant.details.show', ['applicationID' => $todayInterview['application']->id]) }}">
					<span class="card-title">{{ $todayInterview['application']->applicant->name }}</span>
				</a>
			</div>
			<div class="w-200 fz-18 text-center mr-5">
				<a target="_blank"
					class="font-muli-bold text-decoration-none"
					href="{{ $todayInterview['meeting_link']->hangout_link }}">
					<span><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;{{ $todayInterview['meeting_time'] }}</span>
				</a>
			</div>
			<div class="w-200 text-center mr-5">
				<span class="fz-12 badge badge-pill bg-theme-green interviews-data-filter c-pointer" data-id="{{ $todayInterview['application']->job->title }}">{{ $todayInterview['application']->job->title }}</span>
			</div>
			<div class="w-200 text-center mr-5">
			<span class="fz-12 badge badge-pill bg-success interviews-data-filter c-pointer" data-id="{{ $todayInterview['round']->name }}">
			{{ $todayInterview['round']->isTrialRound() ? optional($todayInterview['round']->trialRound)->name : $todayInterview['round']->name }}</span>
			</div>
			<div class="w-200 mr-5 d-none {{ 3 === auth()->id() ? '' : 'd-none' }}">
				<span class="fz-12">
					<i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;<strong>Assignee : </strong>{{ $todayInterview['scheduled_person']['name'] }}</span>
				</div>
			<div class="w-100 text-center text-white">
				<span class="fz-12 badge badge-pill bg-secondary interviews-data-filter c-pointer" data-id="{{ $todayInterview['application']->job->type }}">{{ ucfirst($todayInterview['application']->job->type) }}</span>
			</div>
		</div>
	</div>
</div>

<?php endforeach; ?>