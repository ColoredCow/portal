@extends('prospect::layouts.master')
@section('content')

<div class="container" id="">
    {{-- @include('prospect::menu_header') --}}
    <br>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1">{{ config('prospect.status')[request()->input('status', 'active')] }} Prospects ({{ $count?? 0 }})</h4>
        <span>
            <a  href= "{{ route('prospect.create') }}" class="btn btn-info text-white"> Add new prospects</a>
        </span>
    </div>
    
    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr class="top">
                    <th>Name</th>
                    <th>Resources</th>
                    <th>Requirements</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prospects ?? [] as $prospect)
                    <tr>
                        <td>
                          <a href="{{ route('prospect.show', $prospect) }}">{{ $prospect->name }}</a>  
                        </td>
                        <td>{{$prospect->Resources}}</td>
                        <td>{{$prospect->Requirement}}</td>
                        <td>
                        <i  type="submit" class="fa fa-trash fz-20 text-theme-red" data-toggle="modal" data-target="#delete"></i>
                        </td>
                    </tr>
                @empty+
                    <tr>
                        <td colspan="2">
                            <p class="my-4 text-left">No {{ config('prospect.status')[request()->input('status', 'active')] }} prospects found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
    @include('prospect::delete')
</div>
@endsection