@extends('project::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    @include('project::menu_header')
    <br>
    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1">Clients</h4>
        <span>
            <a  href= "{{ route('client.create') }}" class="btn btn-info text-white"> Add new client</a>
        </span>
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Key Account Manager</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients?:[] as $client)
                    <tr>
                        <td> <a href="{{ route('client.edit', $client) }}">{{ $client->name }}</a> </td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->keyAccountManager->name }}</td>
                        <td>{{ config('client.status')[$client->status] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    
</div>
@endsection