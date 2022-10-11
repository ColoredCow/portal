@extends('media::layouts.master')
@section('title', 'Edit Post')
@section('heading', 'Edit Media Item')
@section('link_text', 'Go to All Posts')
@section('link', route('media.index'))

@section('content')

<div class="row my-3">
    <div class="col-lg-6 mx-auto">
        <div class="card shadow">
            <div class="card-header bg-secondary">
                <h3 class="text-light fw-bold">Edit Post</h3>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('media.update', $media->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="my-2"><h3 class="text-secondary">Event Name</h3>
                        <input type="text" name="event_name" id="eventName" class="form-control" placeholder="Event Name" value="{{ $media->event_name }}" required>
                    </div>
                    <div class="my-2"><h3 class="text-secondary">File Upload</h3>
                        <input type="file" name="file" id="file" accept="image/*" class="form-control">
                    </div>
                    @if(pathinfo($media->file_url, PATHINFO_EXTENSION) == 'mp4' || pathinfo($media->file_url, PATHINFO_EXTENSION) == 'mpeg' || pathinfo($media->file_url, PATHINFO_EXTENSION) == 'mov' ||  pathinfo($media->file_url, PATHINFO_EXTENSION) == 'avi'  )
                    <video class="container" controls>
                        <source src="{{asset('storage/media/'.$media->file_url)}}" type="video/mp4">
                    </video>
                    @endif
                    @if(pathinfo($media->file_url, PATHINFO_EXTENSION) == 'jpg' || pathinfo($media->file_url, PATHINFO_EXTENSION) == 'jpeg' || pathinfo($media->file_url, PATHINFO_EXTENSION) == 'png' )
                        <img src="{{ asset('storage/media/'.$media->file_url) }}" class="card-img-top img-fluid ">
                    @endif
                    <div class="my-2"><h3 class="text-secondary">Description</h3>
                        <textarea name="description" id="description" rows="6" class="form-control" placeholder="Description" required>{{ $media->description }}</textarea>
                    </div>
                    <div class="my-2">
                        <div>
                            <a href="@yield('link')" class="btn btn-secondary float-right ml-3">@yield('link_text')</a>
                        </div>
                        <input type="submit" value="Update Post" class="btn btn-success float-right">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
