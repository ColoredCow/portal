@extends('project::layouts.master')
@section('content')

<div class="container">
	{{-- @include('project::menu_header') --}}
    <br><h4>Add new project</h4>
    <div class="">
        @include('status', ['errors' => $errors->all()])
        <div class="card">
            <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data" id="form_project">
                @csrf
                <div class="card-header">
                    <span>Project Details</span>
                </div>
                @include('projectcontract::subviews.create-project-contract-details')
            </form>
        </div>
    </div>
</div>
@endsection

