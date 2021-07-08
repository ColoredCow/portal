@extends('client::layouts.master')
@section('content')

<div class="container" id="show_prospect_details_view">
   
    <div class="fz-24 mb-8 mt-4">
        @if($section != 'prospect-details')
        <a href="{{ route('prospect.show', [$prospect, 'prospect-details'])  }}" class="mb-10">{{ $prospect->name }}</a>
        @endif
    </div>

    @includeWhen($section == 'prospect-details', 'prospect::subviews.show.prospect-details')
    @includeWhen($section == 'prospect-progress', 'prospect::subviews.show.prospect-progress')
</div>

@endsection