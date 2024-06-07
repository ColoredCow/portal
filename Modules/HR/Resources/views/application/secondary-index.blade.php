@extends('hr::layouts.master')

@section('content')

<div class="container">
    <br>
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
        <div class="fz-30 interviews-data-filter c-pointer" data-id="null">
            <p class="mb-0">My Tasks&nbsp;&nbsp;<i class="fa fa-arrow-right fz-24" aria-hidden="true"></i>&nbsp;&nbsp;<span class="badge badge-secondary fz-20 total-interview-tasks"><?php echo $todayInterviews ? count($todayInterviews) : 0 ?></span></p>
        </div>
        <!-- <?php if($todayInterviews) : ?>
            <div class="d-flex align-items-center flex-wrap text-white">
                <?php foreach ( $applicationType as $applicationTypetitle => $applicationTypeData ) : ?>
                        <?php foreach ( $applicationTypeData as $title => $data ) : ?>
                            <?php if($applicationTypetitle === 'job') : ?>
                                <div class="rounded-pill w-fit bg-success text-white fz-14 px-2 py-1 mr-2 fz-14 mb-2">
                                    <span>{{ $title }} - {{ array_sum($data) }}</span>
                                </div>
                            <?php else : ?>
                                <div class="rounded-pill w-fit bg-success text-white fz-14 px-2 py-1 mr-2 fz-14 mb-2">
                                    <span>{{ ucfirst($applicationTypetitle) }} - {{ array_sum($data) }}</span>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?> -->
        <div class="w-500">
            <form class="d-flex justify-content-end align-items-center" method="GET" action="{{ route('secondaryIndex') }}">
                <input
                    type="text" name="searchInterviews" class="form-control" id="searchInterviews" placeholder="Name, Round, or Position"
                    value=@if(request()->has('search')){{request()->get('search')}}@endif>
                <button class="btn btn-info ml-2">Search</button>
            </form>
        </div>
    </div>
        <div class="mt-3">
            <?php if($todayInterviews) : ?>
                <div class="d-flex justify-content-between align-items-center text-white mb-5">
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="rounded-lg bg-primary text-center mr-3 py-1 px-2 interview-date-filter c-pointer" data-id="<?php today()->toDateString(); ?>">
                            <span>Today</span>
                        </div>
                        <div class="rounded-lg bg-primary text-center mr-3 py-1 px-2 interview-date-filter c-pointer" data-id="*">
                            <span>All</span>
                        </div>
                        <div class="badge badge-pill bg-secondary text-center mr-3 d-none selected-category">
                        </div>
                    </div>
                    <div class="interview-loader d-none">
                        <span class="rounded-lg bg-danger text-center py-1 px-2">Loading...</span>
                    </div>
                </div>
                <div class="mt-2">
                    <form class="interview-data-fetch" method="GET" action="{{ route('secondaryIndex') }}">
                            @include('hr::application.today-interviews')
                    </form>
                </div>
            <?php else : ?>
            <div class="d-flex justify-content-center mt-20 w-full">
                <div class="fz-36">
                    <p>No Upcoming meetings for Today</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
@endsection