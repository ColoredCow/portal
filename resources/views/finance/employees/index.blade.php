@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4 class="mb-5 font-weight-bold">Financial Details</h4>
            <br>
            {{-- @include('hr.employees.sub-views.menu', $employee) --}}
            <br><br>
        </div>
        <div class="col-md-12 text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        {{-- <h1 class="mb-5 mt-10 font-weight-bold"> {{ $employees->[name] }} </h4> --}}
                    </div>
                    <div class="col-md-12 text-center">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr class="sticky-top">
                                    <th>Project</th>
                                    <th>Rate
                                        <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="per hour">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        </span>
                                    </th>
                                    <th> Total Billable Efforts</th>
                                    <th>
                                        Earning
                                        <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="Per hour Rate">
                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        </span>
                                    </th>
                                </tr>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>
                                            {{ $employee->project_name }}
                                        </td>
                                        <td>
                                            {{ $employee->service_rates }} {{ $employee->currency ? $employee->currency : 'INR' }}
                                        </td>
                                        <td>
                                            {{ $employee->actual_effort ? $employee->actual_effort : '0' }}
                                        </td>
                                        <td>
                                            {{ number_format($employee->service_rates * $employee->rate_after_conversion * $employee->actual_effort, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3">
                                        <h4>Total</h4>
                                    </td>
                                    <td colspan="1">
                                        @php
                                            $totalServiceRates = number_format(
                                                $employees->sum('total_amount_after_conversion'),
                                                2,
                                            );
                                            $thresholdValue = 109;
                                        @endphp
                                        @if ($thresholdValue <= $totalServiceRates)
                                            <span class="text-success d-flex justify-content-center">
                                                <h4>
                                                    {{ $totalServiceRates }}
                                                </h4>
                                                <span class="d-inline-block pl-2 h-30 w-30">{!! file_get_contents(public_path('icons/green-tick.svg')) !!}</span>
                                            </span>
                                        @else
                                            <span class="text-danger d-flex justify-content-center">
                                                <h4>
                                                    {{ $totalServiceRates }}
                                                </h4>
                                                <span class="d-inline-block h-30 w-30">{!! file_get_contents(public_path('icons/warning-symbol.svg')) !!}</span>
                                            </span>
                                        @endif
                                </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

