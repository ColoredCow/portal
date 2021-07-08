@extends('client::layouts.master')
@section('content')

<div class="container" id="show_prospect_details_view">
   
    <div class="fz-24 mb-8 mt-4">
        <a href="{{ route('prospect.show', [$prospect, 'prospect-details'])  }}" class="mb-10">{{ $prospect->name }}</a>
    </div>

    @include('prospect::checklist.prospect-nda.initiate-nda')
    <br>
    <br>
    {{-- @include('prospect::checklist.prospect-nda.review-nda') --}}
    {{-- @includeWhen($section == 'prospect-progress', 'prospect::subviews.show.prospect-progress') --}}
</div>

@endsection