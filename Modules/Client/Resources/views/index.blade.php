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
                    <th>Client Type</th>
                    <th>Key Account Manager</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients?:[] as $client)
                    <tr>
                        <td> <a href="{{ route('client.edit', $client) }}">{{ $client->name }} </a> </td>
                        <td>
                            <ul class="list-style-none ml-0 pl-1 mb-0">
                                @php $isIndepandet = true; @endphp
                                @if($client->is_channel_partner)
                                <li> Channel Partner</li>
                                @php $isIndepandet = false; @endphp
                                @endif

                                @if($client->has_departments)
                                <li> Parent organisation</li>
                                @php $isIndepandet = false; @endphp
                                @endif

                                @if($client->channel_partner_id)
                                    <li> <span class="font-weight-bold">{{  $client->channelPartner->name  }}</span> is the channel partner</li>
                                    @php $isIndepandet = false; @endphp
                                @endif

                                @if($client->parent_organisation_id)
                                    <li> <span class="font-weight-bold">{{ $client->parentOrganisation->name }}</span> is the parent organisation</li>
                                    @php $isIndepandet = false; @endphp
                                @endif

                                @if($isIndepandet) 
                                <li> - </li>
                                @endif
                            </ul>
                        </td>

                        
                        {{-- <td>{{ $client->email }}</td> --}}
                        <td>{{ optional($client->keyAccountManager)->name ?: '-' }}</td>
                    </tr>
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