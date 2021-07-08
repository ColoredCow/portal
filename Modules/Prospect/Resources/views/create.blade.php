@extends('client::layouts.master')
@section('content')

<div class="container">
	{{-- //@include('client::menu_header') --}}
    <br> <h4 class="mb-5">Add new prospect</h4>
    
    <div>
        @include('status', ['errors' => $errors->all()])
        <div class="card">
            <form action="{{ route('prospect.store') }}" method="POST" id="form_prospect">
                @csrf 
                <div class="card-header">
                    <span>Enter details</span>
                </div>
                @include('prospect::subviews.create-prospect-details')
            </form>
        </div>
    </div>
    
</div>

@endsection

