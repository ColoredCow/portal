
<tr>
	<td>
		<div class="text-start fz-xl-14 text-secondary d-flex flex-column">
			<p class="mb-0 fz-20 text-dark">{{ $todayApplication['application']->applicant->name }}</p>
			<div class="d-flex text-white my-2">
			<a href="{{ route('hr.applicant.details.show', ['applicationID' => $todayApplication['application']->id ]) }}"
				class="btn-sm btn-primary mr-1 text-decoration-none text-center" target="_self">View</a>
			<a href="{{ route('applications.job.edit', $todayApplication['application']->id) }}"
				class="btn-sm btn-primary text-decoration-none text-center" target="_self">Evaluate</a>
			</div>
			<span class="mr-1 text-truncate fz-14">
                <i class="fa fa-envelope-o mr-1"></i>{{ $todayApplication['application']->applicant->email }}</span>
            @if ($todayApplication['application']->applicant->phone)
                <span class="mr-1 fz-14"><i class="fa fa-phone mr-1"></i>{{ $todayApplication['application']->applicant->phone }}</span>
            @endif
            <div>
                @if ($todayApplication['application']->applicant->college && $todayApplication['application']->applicant->university)
                    <span class="mr-1 fz-14"><i class="fa fa-university mr-1"></i>{{ $todayApplication['application']->applicant->college }}</span>
                @endif
            </div>
			<div class="fz-18">
				@if ($todayApplication['application']->applicant->linkedin)
					<a href="{{ $todayApplication['application']->applicant->linkedin }}" target="_blank" data-toggle="tooltip"
						data-placement="top" title="LinkedIn" class="mr-1 text-decoration-none">
						<span><i class="fa fa-linkedin-square" aria-hidden="true"></i></span>
					</a>
				@endif
				@if ($todayApplication['application']->resume)
					<a href="{{ $todayApplication['application']->resume }}" target="_blank" data-toggle="tooltip" data-placement="top"
						title="Resume" class="mr-1 text-decoration-none">
						<span><i class="fa fa-file-text" aria-hidden="true"></i></span>
					</a>
				@endif
			</div>
		</div>
	</td>
	<td>
		<div class="d-flex flex-column">
			<p class="mb-0 fz-18"><i class="fa fa-clock-o pr-1" aria-hidden="true"></i>{{ $todayApplication['meeting_time'] }}</p>
			<span class="fz-16"><i class="fa fa-info-circle pr-1"></i>{{ $todayApplication['application']->job->title }}</span>
			<span class="fz-14 text-secondary">Applied on
                {{ $todayApplication['application']->created_at->format(config('constants.display_date_format')) }}</span>
		</div>
	</td>
	<td>
		<div class="color-primary fz-18">
			<a target="_blank"
				class="font-muli-bold text-decoration-none"
				href="{{ $todayApplication['meeting_link']->hangout_link }}">
				<i class="fa fa-video-camera"
					aria-hidden="true"></i>
				<span>Meeting Link</span>
			</a>
		</div>
	</td>
</tr>
