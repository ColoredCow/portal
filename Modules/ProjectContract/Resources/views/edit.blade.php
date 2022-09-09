@extends('project::layouts.master')
@section('content')

<div class="container">
	{{-- @include('project::menu_header') --}}
    <br><h4>Edit Client Details</h4>
    <div class="">
        @include('status', ['errors' => $errors->all()])
        <div class="card">
            <form action="{{ route('projectcontract.index') }}" method="POST" enctype="multipart/form-data" id="form_project">
                @csrf
                <div class="card-header">
                    <span>Client Details</span>
                </div>
                @include('projectcontract::subviews.edit-client-details')
            </form>
        </div>
    </div>
</div>
@endsection

