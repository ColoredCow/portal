@extends('layouts.app')

@section('content')

<div class="w-md-600 w-300 mx-auto pt-5 text-center">
	<br>
		<h2 class="mb-2 fz-72 fz-md-150"><i class="fa fa-check text-success rounded-circle p-3 bg-white"></i></h2>
		<div class="mt-9">
			<h3>Thanks for submitting the details</h3>
			<a href="{{route('hr.applicant.show-onboarding-applicant-form-details', $hrApplicantId)}}">Click here to Verify</a><br><br><br><br>
			<h3>In case If you want to update the Details</h3>
			<a href="{{route('hr.applicant.view-form',[$hrApplicantId,$hrApplicantEmail])}}">Click here</a>
        </div>
</div>
@endsection