@extends('media::layouts.master')

@section('content')

<div class="container">
    <div class="row g-3 mt-1">
        @forelse($media as $key => $row)
        <div class="col-lg-3 mb-3">
            <div class="card shadow">
                <a href="{{ route('media.show', $row->id) }}">
                    @if(pathinfo($row->file_url, PATHINFO_EXTENSION) == 'mp4' || pathinfo($row->file_url, PATHINFO_EXTENSION) == 'mpeg' || pathinfo($row->file_url, PATHINFO_EXTENSION) == 'mov' ||  pathinfo($row->file_url, PATHINFO_EXTENSION) == 'avi'  )
                    <video class="container" controls>
                        <source src="{{asset('storage/media/'.$row->file_url)}}" type="video/mp4">
                    </video>
                    @endif
                    @if(pathinfo($row->file_url, PATHINFO_EXTENSION) == 'jpg' || pathinfo($row->file_url, PATHINFO_EXTENSION) == 'jpeg' || pathinfo($row->file_url, PATHINFO_EXTENSION) == 'png' )
                        <img src="{{ asset('storage/media/'.$row->file_url) }}" class="card-img-top img-fluid ">
                    @endif
                </a>
                <div class="card-body">
                    <p>
                        <td class="">
                            <img src="{{auth()->user()->avatar}}" alt="{{auth()->user()->name}}" class="w-25 h-25 rounded-circle" data-toggle="tooltip" data-placement="top" title="{{auth()->user()->name}}">
                        </td>
                    </p>
                    <p class="card-title fw-bold text-secondary">Event Name - {{ $row->event_name }}</p>
                    <p class="text-secondary">Description - {{ Str::limit($row->description, 10) }}</p>
                    <div : class="'pl-0 pt-1'">
                        <span v-for="">
                            <h2 class="badge badge-secondary px-2 py-1 mr-1">Events Tag</h2>
                        </span>
                    </div>    
                </div>
            </div>
        </div>
        @empty
        <h2 class="text-center text-secondary p-4">No post found!</h2>
        @endforelse
    </div>
</div>

@endsection