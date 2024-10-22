@extends('prospect::layouts.master')
@section('content')
    @includeWhen(session('status'), 'toast', ['message' => session('status')])
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="mb-2">
            <form class="d-md-flex justify-content-between mt-5 mb-5" action="">
                <div class='d-flex justify-content-between align-items-md-center mb-2 mb-xl-0'>
                    <h4 class="">
                        Active Prospect
                    </h4>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('prospect.create') }}" class="btn btn-success text-white"><i class="fa fa-plus"></i>
                        {{ __('Add new prospect') }}</a>
                </div>
            </form>
        </div>
        <div class='d-md-none mb-2'>
            @can('prospect.create')
                <div class="d-flex flex-row-reverse">
                    <a href="{{ route('prospect.create') }}" class="btn btn-info text-white">{{ __('Add new prospect') }}</a>
                </div>
            @endcan
        </div>
        <div>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="sticky-top">Organization Name</th>
                        <th class="sticky-top">POC</th>
                        <th class="sticky-top">Proposal Sent Date</th>
                        <th class="sticky-top">Domain</th>
                        <th class="sticky-top">Customer Type</th>
                        <th class="sticky-top">Budget</th>
                        <th class="sticky-top">Prospect Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prospects as $prospect)
                        <tr>
                            <td class="w-30p">
                                <div>
                                    <a
                                        href="{{ route('prospect.show', $prospect->id) }}">{{ $prospect->organization_name }}</a>
                                </div>
                            </td>
                            <td class="w-15p">
                                <img src="{{ $prospect->pocUser->avatar }}" class="rounded-circle" width="30"
                                    height="30" alt="{{ $prospect->pocUser->name }}"data-toggle="tooltip"
                                    data-placement="top" title={{ $prospect->pocUser->name }}>
                            </td>
                            <td class="w-25p">
                                <span>{{ \Carbon\Carbon::parse($prospect->proposal_sent_date)->format('M d, Y') }}</span>
                            </td>
                            <td class="w-20p">
                                <span>{{ $prospect->domain }}</span>
                            </td>
                            <td class="w-30p">
                                <span>{{ ucfirst($prospect->customer_type) }}</span>
                            </td>
                            <td class="w-20p">
                                <span>₹{{ number_format($prospect->budget) }}</span>
                            </td>
                            <td class="w-20p">
                                <span class="">{{ $prospect->proposal_status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
