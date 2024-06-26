@extends('hr::layouts.master')

@section('content')
<div class="interview-loader text-center bg-theme-semi-transparent position-fixed w-full h-full d-none" style="top: 0%; right: 0%; z-index: 9999" id="preloader">
	<div class="spinner-border position-relative" style="top: 40%" id="spinner">
		<span class="sr-only">Loading...</span>
	</div>
</div>
<div class="container">
	<div class="nav nav-pills">
		<div class="mr-3 nav-item">
			<a class="nav-item nav-link {{ Request::is('hr/recruitment/opportunities*') ? 'active' : '' }}" href="{{ route('recruitment.opportunities') }}">
				<div class="d-flex align-items-center">
					<p class="mb-0"><i class="fa fa-list-ul"></i> Total Opportunities : </p>
					<p class="mb-0">&nbsp;&nbsp;{{ $totalOpportunities }}</p>
				</div>
			</a>
		</div>
		<div class="nav nav-pills">
			<a class="nav-item nav-link" href="{{ route('recruitment.reports.index') }}">
				<div>
					<h5>Resume Received Today :</h5>
					<!-- <p class="card-text">{{ count($todayApplications) }}</p> -->
					<?php if ( count( $todayApplications ) ) : ?>
						<div class="w-xl-800 w-auto">
							<ul class="d-flex flex-wrap fz-16" style="list-style-type: circle;">
								<?php foreach ( $todayApplications as $title => $todayApplication ) : ?>
									<li class="pb-2 pr-4">
										{{ $title }} - {{ count($todayApplications) }}&nbsp; &nbsp;
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php else : ?>
						<div class="text-dark">
							<p class="fz-16 leading-24"><i class="fa fa-question-circle pr-1"></i>No resume received today</p>
						</div>
					<?php endif; ?>
				</div>
			</a>
		</div>
	</div>
	
	<br>
	<div class="d-flex justify-content-between align-items-start">
		<div class="fz-30 interview-data-reset c-pointer" data-id="null">
			<h1 class="mb-0">My Tasks<sup><span class="badge badge-secondary fz-16 total-interview-tasks ml-1"><?php echo $todayInterviews ? count( $todayInterviews ) : 0; ?></span></sup></h1>
		</div>
		<div class="w-500">
			<form class="d-flex justify-content-end align-items-center">
				<input
					type="text" name="searchInterviews" class="form-control" id="searchInterviews" placeholder="Name, Round, or Designation"
					value>
					<button class="btn btn-info text-white ml-2 interview-search d-flex"><i class="fa fa-search mr-2"></i>Search</button>
			</form>
		</div>
	</div>
	<div class="mt-3">
		<div class="d-flex justify-content-between align-items-center text-white mb-5">
			<div class="d-flex justify-content-start align-items-center fz-20">
				<div class="text-dark rounded-lg text-center mr-3 py-1 px-2 interview-date-filter c-pointer active" data-id>
					<span>Today</span>
				</div>
				<div class="text-dark rounded-lg text-center mr-3 py-1 px-2 interview-date-filter c-pointer" data-id="*">
					<span>All</span>
				</div>
				<div class="fz-14 badge badge-pill bg-primary text-center mr-3 d-none selected-job-category">
					<span></span>
					<i class="fa fa-times pl-1 c-pointer remove-job" aria-hidden="true"></i>
				</div>
				<div class="fz-14 badge badge-pill bg-primary text-center mr-3 d-none selected-round-category">
					<span></span>
					<i class="fa fa-times pl-1 c-pointer remove-round" aria-hidden="true"></i>
				</div>
				<div class="fz-14 badge badge-pill bg-primary text-center mr-3 d-none selected-opportunity-category">
					<span></span>
					<i class="fa fa-times pl-1 c-pointer remove-opportunity" aria-hidden="true"></i>
				</div>
			</div>
		</div>
		<div>
			<div class="d-flex justify-content-start align-items-center shadow-lg w-full py-2 px-3 mb-3 min-h-50 text-white sticky-top interview-header font-weight-bold">
				<div class="w-150 fz-18 text-start mr-5">
					<span>Name</span>
				</div>
				<div class="w-200 fz-18 text-left mr-5">
					<span>Interview Details</span>
				</div>
				<div class="w-180 text-center mr-5">
					<span>Designation</span>
				</div>
				<div class="w-180 text-center mr-5">
					<span>Round</span>
				</div>
				<div class="w-100 text-center text-white">
					<span>Type</span>
				</div>
			</div>
			<form class="interview-data-fetch" method="GET" action="{{ route('applications.interviewsIndex') }}">
				@include('hr::application.today-interviews')
			</form>
		</div>
	</div>
</div>
@endsection
