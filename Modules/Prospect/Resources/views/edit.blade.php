@extends('client::layouts.master')
@section('content')

<div class="container">
    <br> 
    
    @if($section == 'overview')
      <h4 class="mb-5">{{ $prospect->name }}</h4>
    @else
    <h4 class="mb-5">{{ 'Edit Prospect' }}</h4>
    @endif
  
    @include('prospect::subviews.edit.edit-prospect-form-header')
    <div>
        @include('status', ['errors' => $errors->all()])
        <div class="card">

            @includeWhen($section == 'overview', 'prospect::subviews.show.prospect-progress')


            <form id="edit_prospect_info_form" action="{{ route('prospect.update', $prospect) }}" method="POST" >
                <input type="hidden" name="section" value="{{ $section }}">
                <input type="hidden" id="submit_action_input" name="submit_action" value="save-an-exit">
                @csrf 
                @includeWhen( $section == 'prospect-details' ,'prospect::subviews.edit.edit-prospect-details')
                @includeWhen( $section == 'contact-persons' , 'prospect::subviews.edit.edit-prospect-contact-persons')
                @includeWhen( $section == 'prospect-requirements' , 'prospect::subviews.edit.edit-prospect-requirements')
            </form>
        </div>
    </div>
    
</div>

@endsection