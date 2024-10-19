@extends('prospect::layouts.master')
@section('content')
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
            @can('projects.create')
                <div class="d-flex flex-row-reverse">
                    <a href="" class="btn btn-info text-white">{{ __('Add new prospect') }}</a>
                </div>
            @endcan
        </div>
        <div>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="sticky-top">Organization Name</th>
                        <th class="sticky-top">POC</th>
                        <th class="sticky-top">Proposal sent Date</th>
                        <th class="sticky-top">Domain</th>
                        <th class="sticky-top">Customer Type</th>
                        <th class="sticky-top">Budget</th>
                        <th class="sticky-top">Status</th>
                        <th class="sticky-top">Followup sent Date</th>
                        <th class="sticky-top">Followup response</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="w-20p">
                            <div>
                                <a href="">BAT, ATMA, ISDM</a>
                            </div>
                        </td>
                        <td class="w-10p">
                            <span>
                                Vaibhav
                            </span>
                        </td>
                        <td class="w-20p">
                            <span>
                                Aug 7, 2024
                            </span>
                        </td>
                        <td class="w-20p">
                            <span>
                                Social Sector
                            </span>
                        </td>
                        <td class="w-20p">
                            <span>
                                New
                            </span>
                        </td>
                        <td class="w-20p">
                            <span>
                                ₹19,50,000
                            </span>
                        </td>
                        <td class="w-20p">
                            <span>
                                Rejected
                            </span>
                        </td>
                        <td class="w-20p">
                            <span>
                                September 3, 2024
                            </span>
                        </td>
                        <td class="w-20p">
                            <span>
                                Aug 7, 2024
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
