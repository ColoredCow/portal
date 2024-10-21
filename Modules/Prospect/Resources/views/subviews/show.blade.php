@extends('prospect::layouts.master')
@section('content')
    <div class="container">
        <br>
        <h4 class="mb-5 font-weight-bold">Prospect Name:- {{ $prospect->organization_name }}</h4>
        @include('prospect::subviews.prospect-details')
        @include('prospect::subviews.prospect-comments')
    </div>
@endsection
