@extends('hr::layouts.master')
@section('content')
<div class="row d-flex justify-content-center text-center">
@include('status', ['errors' => $errors->all()])
    <br>
    <div class="col-md-12">
        <h1> {{ __('Update Tags') }} </h1>
    </div>
    <br>
    <form action="{{route('hr.tags.update', $tag->id)}}" method="POST" id="update-form">
        @csrf
        @method('PUT')
        <div class="col-md-12">
            <div class="mb-3">
                <label for="label" class="form-label"> {{ __('Label name') }} <strong class="text-danger">*</strong></label>
                <input type="text" class="form-control" id="label" name="name" value="{{ $tag->name }}" >
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label for="description" class="form-label"> {{ __('Description') }} </label>
                <input type="text" class="form-control" id="description" name="description" value="{{ $tag->description }}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label for="color" class="form-label"> {{ __('Color') }} <strong class="text-danger">*</strong></label>
                <input type="color" class="form-control" id="color" name="color" value="{{ $tag->background_color}}" required>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('hr.tags.index') }}';" > {{ __('Back') }} </button>
        <button type="submit" class="btn btn-primary ml-2" form="update-form"> {{ __('Update') }} </button>
    </form>
</div>
@endsection