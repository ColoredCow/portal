@extends('hr::layouts.master')
@section('content')
<div class="container">
    <br>
    <div class="col-md-10">
        <h1> {{ __('Update Tags') }} </h1>
    </div>
    <br>
    <form action="{{route('hr.tags.update', $tags->id)}}" method="POST" id="update-form">
        @csrf
        <div class="mb-3">
            <label for="label" class="form-label"> {{ __('Label name') }} <strong class="text-danger">*</strong></label>
            <input type="text" class="form-control" id="label" name="name" value="{{ $tags->tag_name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label"> {{ __('Description') }} </label>
            <input type="text" class="form-control" id="description" name="description" value="{{ $tags->description }}">
        </div>
        <div class="mb-3">
            <label for="color" class="form-label"> {{ __('Color') }} <strong class="text-danger">*</strong></label>
            <input type="color" class="form-control" id="color" name="color" value="{{ $tags->background_color}}" required>
        </div>
        <button type="button" class="btn btn-secondary" onclick="location.href='{{ route('hr.tags.index') }}';" > {{ __('Back') }} </button>
        <button type="submit" class="btn btn-primary ml-2" form="update-form"> {{ __('Update') }} </button>
    </form>
</div>
@endsection