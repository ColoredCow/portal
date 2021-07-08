@extends('client::layouts.master')
@section('content')

<div class="container" id="vueContainer">
	{{-- //@include('client::menu_header') --}}
    <br> <h4 class="mb-5">Add new client</h4>
    
    <div>
        @include('status', ['errors' => $errors->all()])
        <div class="card">
            <form action="{{ route('client.store') }}" method="POST" id="form_client">
                @csrf 
                <div class="card-header">
                    <span>Enter details</span>
                </div>
                @include('client::subviews.create-client-details')
            </form>
        </div>
    </div>
    
</div>

@endsection

