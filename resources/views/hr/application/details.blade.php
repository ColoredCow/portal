@extends('layouts.app')
@section('content')

    <div class="container">

<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-8">
				<div>Applicant Details</div>
				@foreach ($application->tags as $tag)
					<div class="badge text-uppercase fz-xl-12 c-pointer" style="background-color: {{ $tag->background_color }};color: {{ $tag->text_color  }};" data-toggle="tooltip" data-placement="top" title="{{ $tag->description }}">
						@if ($tag->icon)
							{!! config("tags.icons.{$tag->icon}") !!}
						@endif
						{{ $tag->name }}
					</div>
				@endforeach
				@if (!in_array($application->status, ['in-progress', 'new']))
					<div class="{{ config("constants.hr.status.$application->status.class") }} text-uppercase card-status-highlight fz-12">
						{{ config("constants.hr.status.$application->status.title") }}
					</div>
				@endif
			</div>
			<div class="col-4 text-right">
				<div class="mb-1">
					<a href="/hr/recruitment/job/{{ $application->id }}/edit" class="btn btn-primary" target="_self">Screen resume</a>
					<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#customApplicationMail">Send mail</button>
					@include('hr.custom-application-mail-modal', ['application' => $application])
				</div>
				<div class="text-right fz-14">
					<span class="c-pointer btn-clipboard text-right" data-clipboard-text="{{ $application->getScheduleInterviewLink() }}" data-toggle="tooltip" title="Click to copy">
						<span class="mr-0.16">Interview Schedule link</span>
						<i class="fa fa-clone"></i>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="form-row">
			<div class="form-group col-md-5">
				<label class="text-secondary fz-14 leading-none mb-0.16">Name</label>
				<div>
					{{ $applicant->name }}
					@if ($applicant->linkedin)
						<a href="{{ $applicant->linkedin }}" target="_blank"><i class="fa fa-linkedin-square pl-1 fa-lg"></i></a>
					@endif
				</div>
			</div>
			<div class="form-group offset-md-1 col-md-5">
				<label class="text-secondary fz-14 leading-none mb-0.16">Applied for</label>
				<div>
					<a href="{{ $application->job->link }}" target="_blank">
						<span>{{ $application->job->title }}</span>
						<i class="fa fa-external-link fz-14" aria-hidden="true"></i>
					</a>
				</div>
			</div>
			<div class="form-group col-md-5">
				<label class="text-secondary fz-14 leading-none mb-0.16">Phone</label>
				<div>{{ $applicant->phone ?? '-' }}</div>
			</div>
			<div class="form-group offset-md-1 col-md-5">
				<label class="text-secondary fz-14 leading-none mb-0.16">Email</label>
				<div>{{ $applicant->email }}</div>
			</div>
			<div class="form-group col-md-5">
				<label class="text-secondary fz-14 leading-none mb-0.16">
					College
					<span class="badge badge-danger d-none university-update-failure">Failed to update</span>
					<span class="badge badge-success d-none university-update-success">Updated successfully!</span>
				</label>
				@if(!$applicant->hr_university_id)
					<div id="applicant_college">{{ $applicant->college ?? '-' }}</div>
				@endif
				@if ($universities->isNotEmpty())
					<select name="university_id"
						id="application_university_id"
						class="form-control form-control-sm pr-md-7"
						data-applicant-id="{{ $applicant->id }}">
						<option value="">Select</option>
						@foreach ($universities as $university)
							@php
								$selected = $applicant->hr_university_id == $university->id ? 'selected="selected"' : '';
							@endphp
							<option value="{{ $university->id }}" {{ $selected }}>
								{{ $university->name }}
							</option>
						@endforeach
					</select>
				@endif
			</div>
			<div class="form-group offset-md-1 col-md-5">
				<label class="text-secondary fz-14 leading-none mb-0.16">Course</label>
				<div>{{ $applicant->course ?? '-' }}</div>
			</div>
			<div class="form-group col-md-5">
				<label class="text-secondary fz-14 leading-none mb-0.16">Resume</label>
				<div>
				@if ($application->resume)
					@include('hr.application.inline-resume', ['resume' => $application->resume])
				@else
					–
				@endif
				</div>
			</div>
			<div class="form-group offset-md-1 col-md-5">
				<label class="text-secondary fz-14 leading-none mb-0.16">Graduation Year</label>
				<div>
					{{ $applicant->graduation_year ?? '-' }}&nbsp;
					@includeWhen(isset($hasGraduated) && !$hasGraduated, 'hr.job-to-internship-modal', ['application' => $application])
				</div>
			</div>
			@if (isset($applicant->reference))
			<div class="form-group col-md-5">
				<label class="text-secondary fz-14 leading-none mb-0.16">Reference</label>
				<div>{{ $applicant->reference ?? '-' }}</div>
			</div>
			@endif
			@if (isset($applicationFormDetails->value))
				@foreach(json_decode($applicationFormDetails->value) as $field => $value)
					<div class="form-group col-md-12">
						<label class="text-secondary fz-14 leading-none mb-0.16">{{ $field }}</label>
						<div>{{ $value }}</div>
					</div>
				@endforeach
			@endif
		</div>
	</div>
	<form action="/hr/recruitment/applications/rounds/{{ $applicationRound->id }}" method="POST" enctype="multipart/form-data" class="applicant-round-form">
		{{ csrf_field() }}
		{{ method_field('PATCH') }}
		<div class="collapse show">
			<div class="card-body">
				@if ( !$applicationRound->round_status)
					<div class="form-row">
						<div class="form-group col-md-5">
							<label for="scheduled_date" class="fz-14 leading-none text-secondary w-100p">
								<div>
								<i class="fa fa-calendar" aria-hidden="true"></i>
								<span>Scheduled date</span>
									@if($applicationRound->scheduled_date)
										@if($applicationRound->hangout_link)
											<a target="_blank" class="ml-5 font-muli-bold" href="{{ $applicationRound->hangout_link }}">
												<i class="fa fa-video-camera" aria-hidden="true"></i>
												<span>Meeting Link</span>
											</a>
										@endif
									@endif
								</div>
							</label>
							@if ($applicationRound->scheduled_date)
								<input type="datetime-local" 
									name="scheduled_date" id="scheduled_date" 
									class="form-control form-control-sm" 
									value="{{ $applicationRound->scheduled_date->format(config('constants.display_datetime_format')) }}">
							@else
								<div class="fz-16 leading-tight">Pending calendar confirmation</div>
							@endif
						</div>
						<div class="form-group col-md-4">
							<label for="scheduled_person_id" class="fz-14 leading-none text-secondary">
								<i class="fa fa-user" aria-hidden="true"></i>
								<span>Scheduled for</span>
							</label>
							@if ($applicationRound->scheduled_date)
								<select name="scheduled_person_id" id="scheduled_person_id" class="form-control form-control-sm" >
									@foreach ($interviewers as $interviewer)
										@php
											$selected = $applicationRound->scheduled_person_id == $interviewer->id ? 'selected="selected"' : '';
										@endphp
										<option value="{{ $interviewer->id }}" {{ $selected }}>
											{{ $interviewer->name }}
										</option>
									@endforeach
								</select>
							@else
								<div class="fz-16 leading-tight">
									<img src="{{ $applicationRound->scheduledPerson->avatar }}" alt="{{ $applicationRound->scheduledPerson->name }}" class="w-25 h-25 rounded-circle">
									<span>{{ $applicationRound->scheduledPerson->name }}</span>
								</div>
							@endif  
						</div>
						@if ($applicationRound->scheduled_date)
							<div class="form-group col-md-3 d-flex align-items-end">
								<button type="submit" class="py-1 mb-0 btn btn-info btn-sm round-submit update-schedule" data-action="schedule-update">Update Schedule</button>
							</div>
						@endif
					</div>
				@endif
			</div>
		</div>
		<input type="hidden" name="action" value="schedule-update">
		<input type="hidden" name="next_round" value="">
	</form>
</div>
</div>

@endsection
