@extends('project::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    @include('client::menu_header')
    <br>
    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1">{{ config('client.status')[request()->input('status', 'active')] }} Clients ({{ $clients ? $clients->count() : '' }})</h4>
        <span>
            <a  href= "{{ route('client.create') }}" class="btn btn-info text-white"> Add new client</a>
        </span>
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Reference Id</th>
                    <th>Email</th>
                    <th>Key Account Manager</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients?:[] as $client)
                    <tr>
                        <td> <a href="{{ route('client.edit', $client) }}">{{ $client->name }} </a> </td>
                        <td> {{ $client->reference_id }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ optional($client->keyAccountManager)->name ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <p class="my-4 text-left">No {{ config('client.status')[request()->input('status', 'active')] }} clients found.</p>
                        <td>
                    </tr>
                    
                @endforelse
            </tbody>
        </table>

    </div>
    
</div>
@endsection