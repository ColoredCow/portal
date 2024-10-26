@extends('prospect::layouts.master')
@section('content')
    <div class="container">
        <br>
        <div class="d-flex justify-content-between mb-5">
            <h4 class="font-weight-bold">Prospect Name: {{ $prospect->organization_name }}</h4>
            <a href="{{ route('prospect.edit', $prospect->id) }}" class="btn btn-primary">Edit</a>
        </div>
        @include('prospect::subviews.prospect-details')
        @include('prospect::subviews.prospect-comments')
        @include('prospect::subviews.prospect-insights')
    </div>
@endsection
