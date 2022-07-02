@extends('project::layouts.master')
@section('content')
<div class="container" id="vueContainer">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="d-none d-md-flex justify-content-between my-2">
        @include('client::menu_header')
        @can('clients.create')
            <a href= "{{ route('client.create') }}" class="btn btn-info text-white active">Add client</a>
        @endcan
    </div>
    <div class="d-md-flex justify-content-between mt-5 mb-2">
        <h4 class="mb-1 pb-1">{{ config('client.status')[request()->input('status', 'active')] }} Clients ({{ $count }})</h4>
        <div>
            <form action="{{ route('client.index') }}" method="GET">
                <div class="d-flex align-items-center">
                    <input type="hidden" name="status" value="{{ request()->get('status', 'active') }}">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Client name" value={{request()->get('name')}}>
                    <button class="btn btn-info ml-2 text-white active">Search</button> 
                </div>
            </form>
        </div>
    </div>
    <div class='d-md-none mb-2'>
        @can('clients.create')
            <div class="d-flex flex-row-reverse">
                <a href= "{{ route('client.create') }}" class="btn btn-info text-white">Add client</a>
            </div>
        @endcan
        @include('client::menu_header')
    </div>
    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Client Type</th>
                    <th>Key Account Manager</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients?:[] as $client)
                    @include('client::subviews.listing-client-row', ['client' => $client, 'level' => 0])
                
                    @foreach($client->linkedAsPartner as $partnerClient)
                        @include('client::subviews.listing-client-row', ['client' => $partnerClient, 'level' => 1])
                    @endforeach

                    @foreach($client->linkedAsDepartment as $department)
                        @include('client::subviews.listing-client-row', ['client' => $department, 'level' => 1])
                    @endforeach

                @empty
                    <tr>
                        <td>  </td>
                        <td> - </td>
                        <td>  </td>
                            <p class="my-4 text-left">No {{ config('client.status')[request()->input('status', 'active')] }} clients found.</p>
                        <td>
                    </tr>
                   

                @endforelse
            </tbody>
        </table>

    </div>
    
</div>
@endsection