@extends('hr::layouts.master')

@section('content')

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
		<div class="nav nav-pills mr-3">
			<a class="nav-item nav-link" href="{{ route('recruitment.reports.index') }}">
				<div class="">
					<h5 class="">Resume Received Today</h5>
					<!-- <p class="card-text">{{ count($todayApplications) }}</p> -->
					<div class="max-h-60" style="overflow-y: scroll; scrollbar-width: none">
						<ol class="d-flex" style="list-style-type: lower-alpha;">
							<?php foreach ( $todayApplications as $title => $todayApplication ) : ?>
								<li class="pb-2">
									{{ $title }} : {{ count($todayApplications) }}&nbsp; &nbsp;
								</li>
							<?php endforeach; ?>
						</ol>
					</div>
				</div>
			</a>
		</div>
	</div>
	
	<br>
	<div class="d-flex justify-content-between align-items-start">
		<div class="fz-30 interview-data-reset c-pointer" data-id="null">
			<h1 class="mb-0">My Tasks&nbsp;&nbsp;<i class="fa fa-arrow-right fz-24" aria-hidden="true"></i>&nbsp;&nbsp;<span class="badge badge-secondary fz-20 total-interview-tasks"><?php echo $todayInterviews ? count( $todayInterviews ) : 0; ?></span></h1>
		</div>
		<div class="w-500">
			<form class="d-flex justify-content-end align-items-center">
				<input
					type="text" name="searchInterviews" class="form-control" id="searchInterviews" placeholder="Name, Round, or Designation"
					value>
				<button class="btn btn-info ml-2 interview-search">Search</button>
			</form>
		</div>
	</div>
	<div class="mt-3">
		<div class="d-flex justify-content-between align-items-center text-white mb-5">
			<div class="d-flex justify-content-start align-items-center">
				<div class="fz-24 text-dark rounded-lg text-center mr-3 py-1 px-2 interview-date-filter c-pointer active" data-id>
					<span>Today</span>
				</div>
				<div class="fz-24 text-dark rounded-lg text-center mr-3 py-1 px-2 interview-date-filter c-pointer" data-id="*">
					<span>All</span>
				</div>
				<div class="badge badge-pill bg-theme-green text-center mr-3 d-none selected-job-category">
					<span></span>
					<i class="fa fa-times pl-1 c-pointer remove-job" aria-hidden="true"></i>
				</div>
				<div class="badge badge-pill bg-success text-center mr-3 d-none selected-round-category">
					<span></span>
					<i class="fa fa-times pl-1 c-pointer remove-round" aria-hidden="true"></i>
				</div>
				<div class="badge badge-pill bg-secondary text-center mr-3 d-none selected-opportunity-category">
					<span></span>
					<i class="fa fa-times pl-1 c-pointer remove-opportunity" aria-hidden="true"></i>
				</div>
			</div>
			<div class="interview-loader d-none btn btn-primary">
				<span class="rounded-lg text-center py-1 px-2">Loading...</span>
			</div>
		</div>
		<div>
			<div class="d-flex justify-content-start align-items-center shadow-lg w-full py-2 px-3 mb-3 min-h-70 text-white sticky-top interview-header">
				<div class="w-150 fz-18 text-start mr-5">
					<span>NAME</span>
				</div>
				<div class="w-200 fz-18 text-left mr-5">
					<span>INTERVIEW DETAILS</span>
				</div>
				<div class="w-200 text-center mr-5">
					<span>DESIGNATION</span>
				</div>
				<div class="w-200 text-center mr-5">
					<span>ROUND</span>
				</div>
				<div class="w-100 text-center text-white">
					<span>INTERVIEW TYPE</span>
				</div>
			</div>
			<form class="interview-data-fetch" method="GET" action="{{ route('interviewsIndex') }}">
				@include('hr::application.today-interviews')
			</form>
		</div>
	</div>
</div>
@endsection
