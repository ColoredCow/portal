@extends('media::layouts.master')
@section('title', 'Media Page')
@section('heading', 'Media')
@section('popup', 'Add New Post')
@section('link', route('media.index'))
@section('content')

@if(session('message'))
<div class="alert alert-{{ session('status') }} alert-dismissible fade show" role="alert">
  <strong>{{ session('message') }}</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="container">
  <div class="row my-2">
    <div class="col-lg-12 d-flex justify-content-between align-items-center mx-auto">
      <div>
        <h1>@yield('heading')</h1>
      </div>
      <div>
        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#photoGallery">
          <a>@yield('popup')</a>
        </button>
        <div class="modal fade" id="photoGallery" tabindex="-1" role="dialog" aria-labelledby="photoGalleryLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row my-3">
                  <div class="col-lg-20 mx-auto">
                    <div class="card shadow">
                      <div class="card-header bg-secondary">
                        <h3 class="text-light fw-bold">Add New Post</h3>
                      </div>
                      <div class="card-body p-4">
                        <form action="{{ route('media.index') }}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="my-2"><h3 class="text-secondary">Event Name</h3>
                            <input type="text" name="event_name" id="event_name" class="form-control @error('event_name') is-invalid @enderror" placeholder="Event_name" value="{{ old('event_name') }}">
                            @error('event_name')
                              <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                          <div class="my-2"><h3 class="text-secondary">File Upload</h3>
                            <input type="file" name="file" id="file" accept="image/*" class="form-control @error('file') is-invalid @enderror">
                            @error('file')
                              <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                          <div class="my-2"><h3 class="text-secondary">Description</h3>
                            <textarea name="description" id="description" rows="6" class="form-control @error('description') is-invalid @enderror" placeholder="Description">{{ old('description') }}</textarea>
                            @error('description')
                              <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                          </div>
                          <div class="my-2">
                            <input type="submit" value="Add Post" class="btn btn-success float-right">
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div> 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr class="my-3">
  @yield('content')
</div>
<div class="container">
  <div class="row g-3 mt-1">
    @forelse($media as $key => $row)
    <div class="col-lg-3 mb-3">
      <div class="card shadow">
        <a href="{{ route('media.show', $row->id) }}">
          <img src="{{ asset('storage/media/'.$row->img_url) }}" class="card-img-top img-fluid ">
        </a>
        <div class="card-body">
          <p>
            <td class="">
            <img src="{{auth()->user()->avatar}}" alt="{{auth()->user()->name}}" class="w-25 h-25 rounded-circle"
              data-toggle="tooltip" data-placement="top" title="{{auth()->user()->name}}">
            </td>
          </p>
        <p class="card-title fw-bold text-secondary">Event Name - {{ $row->event_name }}</p>
        <p class="text-secondary">Description - {{ Str::limit($row->description, 10) }}</p>
        </div>
      </div>
    </div>
    @empty
      <h2 class="text-center text-secondary p-4">No post found in the database!</h2>
    @endforelse
    <div class="d-flex justify-content-center">
      {{ $media->onEachSide(1)->links() }}
    </div>
  </div>
</div>
@endsection
