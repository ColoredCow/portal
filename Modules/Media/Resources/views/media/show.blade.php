@extends('media::layouts.master')
@section('title', 'Post Details')
@section('heading', 'Post Details')
@section('link_text', 'See All Posts')
@section('link', route('media.index'))

@section('content')

<div class="row my-4">
    <div class="col-lg-4 mx-auto">
        <div class="card shadow">
            @if(pathinfo($media->file_url, PATHINFO_EXTENSION) == 'mp4' || pathinfo($media->file_url, PATHINFO_EXTENSION) == 'mpeg' || pathinfo($media->file_url, PATHINFO_EXTENSION) == 'mov' ||  pathinfo($media->file_url, PATHINFO_EXTENSION) == 'avi'  )
            <video class="container" controls>
                <source src="{{asset('storage/media/'.$media->file_url)}}" type="video/mp4">
            </video>
            @endif
            @if(pathinfo($media->file_url, PATHINFO_EXTENSION) == 'jpg' || pathinfo($media->file_url, PATHINFO_EXTENSION) == 'jpeg' || pathinfo($media->file_url, PATHINFO_EXTENSION) == 'png' )
                <img src="{{ asset('storage/media/'.$media->file_url) }}" class="card-img-top img-fluid ">
            @endif
            <div class="card-body p-5">
                <div class="d-flex justify-content-between align-items-center">
                    <p>
                        <td class="">
                            <img src="{{auth()->user()->avatar}}" alt="{{auth()->user()->name}}" class="w-25 h-25 rounded-circle" data-toggle="tooltip" data-placement="top" title="{{auth()->user()->name}}">
                        </td>
                    </p>
                    <p class="lead">
                        {{ $time }}
                    </p>
                </div>
                <p class="fw-bold text-secondary">Event Name - {{ $media->event_name }}</p>
                <p class="fw-bold text-secondary">Description - {{ $media->description }}</p>
            </div>
            <div class="card-footer px-5 py-3 d-flex justify-content-end">
                <div>
                    <a href="@yield('link')" class="btn btn-secondary float-right mr-17">@yield('link_text')</a>
                </div>
                <a href="{{ route('media.edit', $media->id) }}" class="btn btn-success float-right mr-2">Edit</a>
                <form action="{{ route('media.destroy', $media->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger float-right">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
