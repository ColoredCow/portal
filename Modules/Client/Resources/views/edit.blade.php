@extends('client::layouts.master')
@section('content')

<div class="container" id="vueContainer">

    <br> <h4 class="mb-5 font-weight-bold">{{ $client->name }}</h4>

    @include('client::subviews.edit-client-form-header')
    
    <div>
        @include('status', ['errors' => $errors->all()]) 
            <div id="edit_client_form_container">
                <form action="{{ route('client.update', $client) }}" method="POST" id="form_client">
                    <input type="hidden" name="section" value="{{ $section }}">
                    @csrf
                    @includeWhen( $section == 'client-details' ,'client::subviews.edit-client-details')
                    @includeWhen( $section == 'client-type' ,'client::subviews.edit-client-type-info')
                </form>
            </div>
    </div>
</div>

@endsection

