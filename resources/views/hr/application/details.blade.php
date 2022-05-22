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
				@dd($application->tags)
			</div>
			<div class="col-4 text-right">
				<div class="mb-1">
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
				{{-- @if ($universities->isNotEmpty())
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
				@endif --}}
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
</div>
</div>

@endsection