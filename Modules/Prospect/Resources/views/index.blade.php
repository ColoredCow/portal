@extends('prospect::layouts.master')
@section('content')
    @includeWhen(session('status'), 'toast', ['message' => session('status')])
    <div class="container">
        @include('prospect::menu-header')
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="mb-2 d-md-flex justify-content-between">
            <div class='d-flex justify-content-between align-items-md-center mt-5 mb-5 mb-xl-0'>
                <h4 class="">
                    Active Prospect
                </h4>
            </div>
            <div class="d-flex align-items-center">
                <a href="{{ route('prospect.create') }}" class="btn btn-success text-white"><i class="fa fa-plus"></i>
                    {{ __('Add new prospect') }}</a>
            </div>
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
                        <th class="sticky-top">Name</th>
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
                                    <a href="{{ route('prospect.show', $prospect->id) }}" class="text-decoration-none">
                                        {{ $prospect->project_name ?? $prospect->organization_name }}
                                    </a>
                                    <br>
                                    <span class="theme-gray-dark fz-12">
                                        {{ $prospect->organization_name ?? ($prospect->client->name ?? '-') }}
                                    </span>
                                </div>
                            </td>
                            <td class="w-15p">
                                <img src="{{ $prospect->pocUser->avatar ?? '' }}" class="rounded-circle" width="30"
                                    height="30" alt="{{ $prospect->pocUser->name ?? '-' }}" data-toggle="tooltip"
                                    data-placement="top" title="{{ $prospect->pocUser->name ?? '-' }}">
                            </td>
                            <td class="w-30p">
                                <span>{{ $prospect->getFormattedDate($prospect->proposal_sent_date) }}</span>
                            </td>
                            <td class="w-20p">
                                <span>{{ $prospect->domain ?? '-' }}</span>
                            </td>
                            <td class="w-20p">
                                <span>{{ ucfirst($prospect->customer_type) ?? '-' }}</span>
                            </td>

                            <td class="w-30p">
                                <span>
                                    {{ isset($prospect->currency) && isset($currencySymbols[$prospect->currency]) ? $currencySymbols[$prospect->currency] : '' }}
                                    {{ $prospect->budget ? $prospect->formattedIndianAmount($prospect->budget) : '-' }}
                                </span>
                            </td>
                            <td class="w-20p">
                                <span
                                    class="">{{ config('prospect.status')[$prospect->proposal_status] ?? '-' }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        {{ $prospects->appends(request()->query())->links() }}
    </div>
@endsection
