@extends('prospect::layouts.master')
@section('content')
    @includeWhen(session('status'), 'toast', ['message' => session('status')])
    <div class="container">
        <br>
        <h4 class="mb-5">Edit Prospect</h4>
        <ul class="nav nav-pills mb-2" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="prospectDetails-tab" data-toggle="pill" href="#prospectDetails" role="tab"
                    aria-controls="prospectDetails" aria-selected="true">Prospect Details</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="prospectComments-tab" data-toggle="pill" href="#prospectComments" role="tab"
                    aria-controls="prospectComments" aria-selected="false">Prospect Comments</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="prospectInsights-tab" data-toggle="pill" href="#prospectInsights" role="tab"
                    aria-controls="prospectInsights" aria-selected="false">Prospect Insights / Learning</a>
            </li>
        </ul>

        @include('status', ['errors' => $errors->all()])
        <div class="tab-content mt-5" id="pills-tabContent">
            <div class="tab-pane fade show active" id="prospectDetails" role="tabpanel"
                aria-labelledby="prospectDetails-tab">
                @include('prospect::subviews.edit-prospect-details')
            </div>

            <div class="tab-pane fade" id="prospectComments" role="tabpanel" aria-labelledby="prospectComments-tab">
                @include('prospect::subviews.edit-prospect-comment')
            </div>

            <div class="tab-pane fade" id="prospectInsights" role="tabpanel" aria-labelledby="prospectInsights-tab">
                @include('prospect::subviews.edit-prospect-insights')
            </div>
        </div>
    </div>
@endsection
