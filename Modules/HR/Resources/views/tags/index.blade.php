@extends('hr::layouts.master')
@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-md-10">
            <h1>Tags</h1>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-success btn-block btn-lg" data-bs-toggle="modal" data-bs-target="#createModal">
            {{ __('New Tag') }}
            </button>
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="tags_table">
            <tr>
                <th>{{ __('Tag Name') }}</th>
                <th>{{ __('Description') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
            @foreach ($tags as $tag)
            <tr>
                <td><div class="rounded w-13 h-13 d-inline-block mr-1" style="background-color: {{ $tag->background_color }};color: {{ $tag->text_color }};"></div>{{ $tag->name }}</td>
                <td>{{ $tag->description }}</td>
                <td>
                    <form action="{{ route('hr.tags.delete', $tag->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a title="Edit" class="pr-1 btn btn-link" href="{{ route('hr.tags.edit', $tag) }}"><i class="text-success fa fa-edit fa-lg"></i></a>
                        <button type="submit" class="pl-1 btn btn-link" onclick="return confirm('Are you sure you want to delete?')"><i class="text-danger fa fa-trash fa-lg"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@include('hr::tags.create-tag-modal')
@endsection