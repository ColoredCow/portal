@extends('layouts.app')

@section('content')
	<div class="w-md-600 w-300 mx-auto pt-5 text-center">
	<br>
		<h2 class="mb-2 fz-72 fz-md-150"><i class="fa fa-check text-success rounded-circle p-3 bg-white"></i></h2>
		<div class="mt-9">
			<h4 class="fz-md-36 fz-28">Hello {{ $application->applicant->name }} 👋</h4>
			<p class="mt-10 fz-md-28 fz-24 leading-30"><b><i>Thanks for the verification 🙌</i></b></p>
			<p class="mt-5">We will be in touch via emails 📩 from here, infact we sent one with some useful resources to help clearing the interviews</p>
			{{-- We need to make this email dynamic, it will be fetched from config in future --}}
			<p class="mt-5">Queries? 🤔  Write at<a href="mailto:pankaj.kandpal@coloredcow.in"> pankaj.kandpal@coloredcow.in</a></p>
		</div>
	</div>
@endsection