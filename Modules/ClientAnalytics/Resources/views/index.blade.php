@extends('clientanalytics::layouts.master')
@section('content')
<div class="project-effort-tracking-container container py-10">
    <a href="{{ route('client.index') }}" class="text-theme-body text-decoration-none mb-2 mb-xl-4 align-items-center">
        <span class="mr-1 d-inline-flex w-8 h-8 w-xl-12 h-xl-12">
            {!! file_get_contents(public_path('icons/prev-icon.svg')) !!}
        </span>
        <span>Back To Client</span>
    </a>

    <div class="d-flex justify-content-between">
        <h1>Clients</h1>
        <div class="form-group mr-0 ml-1 mt-1 w-168">
            <label for="dataFilter">Filter Data:</label>
            <select id="dataFilter" class="form-control">
                <option value="date">Date</option>
                <option value="month" selected>Month</option>
                <option value="year">Year</option>
            </select>
        </div>
    </div>
    <input type="hidden" name="clients" value="{{$clients}}">
    <canvas id="clientChart" width="400" height="200"></canvas>
    
</div>
@endsection

