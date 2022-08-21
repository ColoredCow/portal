@extends('media::layouts.master')
@section('content')
@section('title', 'Add New Post')
@section('heading', 'Create a New Post')
@section('link_text', 'Goto All Posts')
@section('link', '/post')
<div class="row my-3">
  <div class="col-lg-8 mx-auto">
    <div class="card shadow">
      <div class="card-header bg-primary">
        <h3 class="text-light fw-bold">Add New Post</h3>
      </div>
      <div class="card-body p-4">
        <form action="/post" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="my-2">
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Title" value="{{ old('title') }}">
            @error('title')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="my-2">
            <input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" placeholder="Category" value="{{ old('category') }}">
            @error('category')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="my-2">
            <input type="file" name="file" id="file" accept="image/*" class="form-control @error('file') is-invalid @enderror">
            @error('file')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="my-2">
            <textarea name="content" id="content" rows="6" class="form-control @error('content') is-invalid @enderror" placeholder="Post Content">{{ old('content') }}</textarea>
            @error('content')
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
@endsection
