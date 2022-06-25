@extends('layouts.app')

@section('content')
	<div class="container text-center">
	<br>
		<h2 class="mb-2 fz-36 fz-md-48"><i class="fa fa-check text-success rounded-circle p-3 bg-white"></i></h2>
		<div class="mt-4">
			<h4>Hello {{ $application->applicant->name }}</h4>
			<p>Your email {{ $application->applicant->email }} is successfully verified </p>
		</div>
	</div>
@endsection