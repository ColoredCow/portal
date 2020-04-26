@extends('client::layouts.master')
@section('content')

<div class="container">
	{{-- //@include('client::menu_header') --}}
    <br> <h4 class="mb-5">Edit prospect prospect</h4>
    @include('prospect::subviews.edit-prospect-form-header')
    <div>
        @include('status', ['errors' => $errors->all()])
        <div class="card">
            <form id="edit_prospect_info_form" action="{{ route('prospect.update', $prospect) }}" method="POST" >
                <input type="hidden" name="section" value="{{ $section }}">
                <input type="hidden" id="submit_action_input" name="submit_action" value="save-an-exit">
                @csrf 
                @includeWhen( $section == 'prospect-details' ,'prospect::subviews.edit-prospect-details')
                @includeWhen( $section == 'contact-persons' , 'prospect::subviews.edit-prospect-contact-persons')
                {{-- @includeWhen( $section == 'address' ,'client::subviews.edit-client-address')
                @includeWhen( $section == 'billing-details' ,'client::subviews.edit-client-billing-details')
                @includeWhen( $section == 'client-type' ,'client::subviews.edit-client-type-info') --}}
            </form>
        </div>
    </div>
    
</div>

@endsection