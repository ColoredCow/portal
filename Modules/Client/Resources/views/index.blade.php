@extends('project::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    @include('client::menu_header')
    <br>
    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1">{{ config('client.status')[request()->input('status', 'active')] }} Clients ({{ $count }})</h4>
        <span>
            <a  href= "{{ route('client.create') }}" class="btn btn-info text-white"> Add new client</a>
        </span>
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
                        <td colspan="2">
                            <p class="my-4 text-left">No {{ config('client.status')[request()->input('status', 'active')] }} clients found.</p>
                        <td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
    
</div>
@endsection