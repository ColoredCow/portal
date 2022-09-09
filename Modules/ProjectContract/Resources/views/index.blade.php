@extends('projectcontract::layouts.master')

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
    <div class='d-none d-md-flex justify-content-end'>
        <span class='mt-4'>
            <a href= "{{ route('projectcontract.create') }}" class="btn btn-info text-white">{{ __('Add new project contract') }}</a>
        </span>
    </div>
    <div class="mb-2 mt-2">
        <form class="d-md-flex justify-content-between ml-md-3">
            <div class='d-flex justify-content-between align-items-md-center mb-2 mb-xl-0'>
                <h4 class="">Project Contracts</h4>
            </div>
            <div class="d-flex align-items-center">
                <input type="text" name="name" class="form-control" id="name" placeholder="Client name"
                value={{request()->get('name')}}>
                <button class="btn btn-info ml-2 text-white">Search</button>
            </div>
        </form>
    </div>
    <div class='d-md-none mb-2'>
        <div class="d-flex flex-row-reverse">
            <a href= "{{ route('projectcontract.create') }}" class="btn btn-info text-white">{{ __('Add new project contract') }}</a>
        </div>
    </div>
    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th class="w-33p sticky-top">Client Name</th>
                    <th class="sticky-top">Team Members</th>
                    <th class="sticky-top">Actions</th>
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
