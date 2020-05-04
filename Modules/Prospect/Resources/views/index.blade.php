@extends('prospect::layouts.master')
@section('content')

<div class="container" id="">
    {{-- @include('prospect::menu_header') --}}
    <br>
    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1">{{ config('prospect.status')[request()->input('status', 'active')] }} Prospects ({{ $count?? 0 }})</h4>
        <span>
            <a  href= "{{ route('prospect.create') }}" class="btn btn-info text-white"> Add new prospects</a>
        </span>
    </div>
    
    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Coming from</th>
                    <th>Assignee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prospects ?? [] as $prospect)
                    <tr>
                        <td>
                          <a href="{{ route('prospect.show', $prospect) }}">{{ $prospect->name }}</a>  
                        </td>
                        <td>{{ \Str::title($prospect->coming_from ) }}</td>
                        <td>{{ optional($prospect->assignTo)->name }}</td>
                        <td>
                            {{-- <div>
                                <a href="{{ route('prospect.edit', $prospect) }}" class="d-none btn btn-info btn-sm">Edit</a>
                            </div> --}}
                            
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="2">
                            <p class="my-4 text-left">No {{ config('prospect.status')[request()->input('status', 'active')] }} prospects found.</p>
                        <td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
    
</div>
@endsection