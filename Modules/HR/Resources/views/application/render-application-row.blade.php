<tr>
    <td class="w-25p">
        <div class="d-flex align-items-center">
            <div class="d-flex align-items-center">
                <h2 class="fz-16 m-0 mr-1">{{ $application->applicant->name }}</h2>
                <button class="assignlabels outline-none " title="Assign labels" data-toggle="modal"
                    data-target="#assignlabelsmodal" type="button">{!! file_get_contents(public_path('icons/three-dots-vertical.svg')) !!}</button>
            </div>

            @php
            $formData = $application->applicationMeta()->formData()->first();
            @endphp
            @if (isset($formData->value))
            @php
            $tooltipHtml = '';
            $index = 0;
            foreach (json_decode($formData->value) as $field => $value) {
            if (!$value) continue;
            $tooltipHtml .= "$field<br />";
            $tooltipHtml .= "$value\n\n";
            break;
            }
            @endphp
            @if ($tooltipHtml)
            <span class="mr-1">
                <i class="fa fa-eye" aria-hidden="true" class="text-secondary c-pointer" data-toggle="tooltip"
                    data-placement="top" data-html="true" title="{!! $tooltipHtml !!}"></i>
            </span>
            @endif
            @endif
        </div>
        @include('hr.application.assignlabels-modal')
        @php
        $assignee = $application->latestApplicationRound->scheduledPerson;
        @endphp
        <div class="mb-2 fz-xl-14 text-secondary d-flex flex-column">
            <div class="d-flex text-white my-2">
            
                <a href="{{ route('hr.applicant.details.show', ['applicationID' => $application->id]) }}" class="btn-sm btn-primary mr-1 text-decoration-none" target="_self">View</a>
                @if ($application->latestApplicationRound->scheduledPerson->id == auth()->user()->id)
                    <a href="{{ route('applications.job.edit', $application->id) }}" class="btn-sm btn-primary text-decoration-none" target="_self">Evaluate</a>
                @else
                    <a data-target="#evaluation{{$application->id}}" role="button" class="btn-sm btn-primary text-decoration-none" data-toggle="modal">Evaluate</a>
                    <div class="modal fade" id="evaluation{{$application->id}}" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-secondary" id="confirmation">Request to handover</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-secondary">This application is already assigned to {{$assignee->name}}, to evaluate this, a confirmation would be needed from their end. Please click the request button to request the handover.</p>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <a href="{{ route('application.handover', $application) }}" class="btn btn-primary">Request</a></button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <span class="mr-1 text-truncate">
                <i class="fa fa-envelope-o mr-1"></i>{{ $application->applicant->email }}</span>
            @if ($application->applicant->phone)
            <span class="mr-1"><i class="fa fa-phone mr-1"></i>{{ $application->applicant->phone }}</span>
            @endif
            <div>
                @if ($application->applicant->college && $application->applicant->university)
                <span class="mr-1"><i class="fa fa-university mr-1"></i>{{ $application->applicant->college }}</span>
                <a href ="{{ route('universities.edit',$application->applicant->university) }}"target="_blank" >
                     @if($application->applicant->university->universityContacts->first() && $application->applicant->university->universityContacts->first()->phone)
                        <span class="badge badge-pill badge-success mr-1  mt-1 ">See contact</span>
                    @else
                        <span class="badge badge-pill badge-danger mr-1  mt-1 ">Add contact</span>
                    @endif
                </a>
                @endif
            </div>
        </div>

		<div>
			@if ($application->applicant->linkedin)
			<a href="{{$application->applicant->linkedin}}" target="_blank" data-toggle="tooltip" data-placement="top"
				title="LinkedIn" class="mr-1 text-decoration-none">
				<span><i class="fa fa-linkedin-square" aria-hidden="true"></i></span>
			</a>
			@endif
			@if ($application->resume)
			<a href="{{$application->resume}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Resume"
				class="mr-1 text-decoration-none">
				<span><i class="fa fa-file-text" aria-hidden="true"></i></span>
			</a>
			@endif
		</div>
	</td>
	<td>
		<div class="d-flex flex-column">
			<span>{{ $application->job->title }}   <span data-toggle="tooltip" data-placement="right" title="Total resources required -{{$application->job->resources_required}} Total applications available -{{$openApplicationsCountForJobs[$application->job->title]}}"><i class="fa fa-info-circle"></i>&nbsp;</span></span>
			<span class="fz-xl-14 text-secondary">Applied on
				{{ $application->created_at->format(config('constants.display_date_format')) }}</span>
			<span class="font-weight-bold fz-xl-14 text-dark">
				<span><i class="fa fa-flag mr-1"></i>{{ $application->latestApplicationRound->round->isTrialRound()? optional($application->latestApplicationRound->trialRound)->name : $application->latestApplicationRound->round->name }}</span>
				@if ($application->latestApplicationRound->scheduled_date &&
				$application->latestApplicationRound->round->name != 'Resume Screening')
				<p class="ml-3">
					{{ $application->latestApplicationRound->scheduled_date->format(config('constants.display_daydatetime_format')) }}
				</p>
				@endif
			</span>
		</div>
	</td>
	<td class="">
		<img src="{{$assignee->avatar}}" alt="{{$assignee->name}}" class="w-25 h-25 rounded-circle"
			data-toggle="tooltip" data-placement="top" title="{{$assignee->name}}">
	</td>
	<td>
		<span class="d-flex flex-column align-items-start">
		@if (!in_array($application->status, ['in-progress', 'new']))
		<span
			class="{{ config("constants.hr.status.$application->status.class") }} badge-pill mr-1 mb-1 fz-12">{{ config("constants.hr.status.$application->status.title") }}</span>
		@endif
		@if (!$application->latestApplicationRound->scheduled_date &&
		$application->latestApplicationRound->round->name != "Telephonic Interview" && $application->latestApplicationRound->round->name != "Team Interaction Round")
		<span class="badge badge-theme-teal text-white badge-pill mr-1 mb-1 fz-12">
			<i class="fa fa-calendar" aria-hidden="true"></i>
			<span>Awaiting confirmation</span>
			@php
			$awaitingForDays =
			$application->latestApplicationRound->getPreviousApplicationRound()->conducted_date->diffInDays(today());
			@endphp
			@if ($awaitingForDays)
			<span>• {{ $awaitingForDays == 1 ? 'day' : 'days' }} {{ $awaitingForDays }}</span>
			@endif
		</span>
		@endif
		@foreach ($application->tags as $tag)
		<span class="badge badge-pill mr-1 mb-1 fz-12 c-pointer"
			style="background-color: {{ $tag->background_color }};color: {{ $tag->text_color  }};" data-toggle="tooltip"
			data-placement="top" title="{{ $tag->description }}">
			@if ($tag->icon)
			{!! config("tags.icons.{$tag->icon}") !!}
			@endif
			<span>
				{{ $tag->name }}

                        @if ($tag->slug == 'need-follow-up' &&
                            ($attempt = optional($application->latestApplicationRound->followUps)->count()))
                            . attempt: {{ $attempt }}
                        @endif

                    </span>

        </span>
        @endforeach
        </span>
    </td>
</tr>