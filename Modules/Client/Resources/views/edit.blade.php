@extends('client::layouts.master')
@section('content')

<div class="container" id="vueContainer">
	{{-- @include('project::menu_header') --}}
    <br> <h4>{{ $client->name }}</h4>
    
    <div>
        @include('status', ['errors' => $errors->all()])
        <div class="card">
            <form action="{{ route('client.update', $client) }}" method="POST" id="form_client">
                @csrf 
                {{ method_field('PUT') }}
                <div class="card-header">
                    <span>Client Details</span>
                </div>
                @include('client::subviews.edit-client-details')
            </form>
        </div>
    </div>
    
</div>

@endsection

