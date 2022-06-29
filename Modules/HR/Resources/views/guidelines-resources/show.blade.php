@extends('hr::layouts.master')
@section('content')
<div class="row col-gap justify-content-center">
    <div class="col-md-7">
        <h3>Resources for Laravel Developer</h3>
    </div>
    <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-block btn-lg"><i class="fa fa-plus"></i>
        {{ __('Add Resources') }}
        </button>
    </div>
    <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa fa-plus"></i>
        {{ __('Add category') }}
        </button>
    </div>
</div>
<div class="container mx-15 mt-5">
    <p>No resource exist for this job. </p>
</div>
<!-- Functionality yet to be created -->
@include('hr::guidelines-resources.create-category-modal')
@endsection