@extends('project::layouts.master')
@section('content')
<div class="container" id="vueContainer">
    @includeWhen(session('success'), 'toast', ['message' => session('success')])
    <div class="d-none d-md-flex justify-content-between my-2">
        @include('client::menu_header')
        @can('clients.create')
            <a href= "{{ route('client.create') }}" class="btn btn-success text-white"><i class="fa fa-plus"></i>Add new client</a>
        @endcan
    </div>
    <div class="d-md-flex justify-content-between mt-5 mb-2">
        <h4 class="mb-1 pb-1">{{ config('client.status')[request()->input('status', 'active')] }} Clients ({{ $count }})</h4>
        <div>
            <form action="{{ route('client.index') }}" method="GET">
                <div class="d-flex align-items-center">
                    <input type="hidden" name="status" value="{{ request()->get('status', 'active') }}">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter the client name" value={{request()->get('name')}}>
                    <button class="btn btn-primary ml-2 text-white">Search</button>
                </div>
            </form>
        </div>
    </div>
    <div class='d-md-none mb-2'>
        @can('clients.create')
            <div class="d-flex flex-row-reverse">
                <a href= "{{ route('client.create') }}" class="btn btn-success text-white mr-1"><i class="fa fa-plus"></i>Add new client</a>
            </div>
        @endcan
        @include('client::menu_header')
    </div>
    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr class="sticky-top">
                    <th class="show">
                        <div class="dropdown">
                        <span data-toggle="dropdown" aria-haspopup="true" class="dropdown-toggle c-pointer">Client Id </span>
                        <div class="dropdown-menu">
                            <div class="dropdown-item c-pointer">
                                <form method="GET" action="{{ route('client.index') }}" class="w-100 m-0 d-grid gap-2">
                                    @csrf
                                    <input type="hidden" name="column_sort" value="client_id">
                                    <input type="hidden" name="order" value="asc">
                                    <button type="submit" class="btn btn-light w-100 d-flex align-items-center">ASC</button>
                                </form>
                            </div>
                            <div class="dropdown-item c-pointer" >
                                <form method="GET" action="{{ route('client.index') }}" class="w-100 m-0 d-grid gap-2">
                                    @csrf
                                    <input type="hidden" name="column_sort" value="client_id" >
                                    <input type="hidden" name="order" value="desc">
                                    <button type="submit" class="btn btn-light w-100 d-flex align-items-center">DESC</button>
                                </form>
                            </div> 
                        </div>
                        </div>
                    </th>
                    <th class="show">
                        <div class="dropdown">
                        <span data-toggle="dropdown" aria-haspopup="true" class="dropdown-toggle c-pointer">Name</span>
                        <div class="dropdown-menu">
                            <div class="dropdown-item c-pointer">
                                <form method="GET" action="{{ route('client.index') }}" class="w-100 m-0 d-grid gap-2">
                                    @csrf
                                    <input type="hidden" name="column_sort" value="name">
                                    <input type="hidden" name="order" value="asc">
                                    <button type="submit" class="btn btn-light w-100 d-flex align-items-center">ASC</button>
                                </form>
                            </div>
                            <div class="dropdown-item c-pointer" >
                                <form method="GET" action="{{ route('client.index') }}" class="w-100 m-0 d-grid gap-2">
                                    @csrf
                                    <input type="hidden" name="column_sort" value="name" >
                                    <input type="hidden" name="order" value="desc">
                                    <button type="submit" class="btn btn-light w-100 d-flex align-items-center">DESC</button>
                                </form>
                            </div> 
                        </div>
                        </div>
                    </th>
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
                        <td colspan="2">
                            <p class="my-4 text-left">No {{ config('client.status')[request()->input('status', 'active')] }} clients found.</p>
                        <td>
                    </tr>
                @endforelse
            </tbody>
        </table>


</div>
@endsection
