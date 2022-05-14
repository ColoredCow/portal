@extends('client::layouts.master')
@section('content')

<div class="container" >

    <br> <h4 class="mb-5 font-weight-bold">Edit client information</h4>

    @include('client::subviews.edit-client-form-header')
    
    <div>
        @include('status', ['errors' => $errors->all()]) 
            <div id="edit_client_form_container">
                <form action="{{ route('client.update', $client) }}" method="POST" id="edit_client_info_form">
                    <input type="hidden" name="section" value="{{ $section }}">
                    <input type="hidden" id="submit_action_input" name="submit_action" value="save-an-exit">
                    @csrf
                    @includeWhen( $section == 'client-details' ,'client::subviews.edit-client-details')
                    @includeWhen( $section == 'contact-persons' ,'client::subviews.edit-client-contact-persons')
                    @includeWhen( $section == 'address' ,'client::subviews.edit-client-address')
                    @includeWhen( $section == 'billing-details' ,'client::subviews.edit-client-billing-details')
                    @includeWhen( $section == 'client-type' ,'client::subviews.edit-client-type-info')
                </form>
                @includeWhen( $section == 'projects' ,'client::subviews.edit-client-projects')
                @include('client::subviews.client-address-modal')
            </div>
    </div>
</div>

@endsection
