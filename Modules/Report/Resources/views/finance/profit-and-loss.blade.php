@extends('report::layouts.master')
@section('content')
    <div class="container" id="vueContainer">
        <br>
        <br>

        <div class="d-flex justify-content-between mb-2">
            <h4 class="mb-1 pb-1"> Profit and Loss Report</h4>
            <span>
                <a href="{{ route('invoice.tax-report-export', request()->all()) }}" class="btn btn-info text-white"> Export
                    To Excel</a>
            </span>
        </div>
        <br>
        <br>

        <div>
            <form action="{{ route('reports.finance.profit-and-loss') }}" id="p&LFilterForm">
                <div class="d-flex">
                    <div class='form-group mr-4 w-168'>
                        <select class="form-control bg-light" name="year"
                            onchange="document.getElementById('p&LFilterForm').submit();">
                            <option {{ request()->input('year') == '' ? 'selected=selected' : '' }} value="">All
                                Years</option>
                            @php $year = now()->year; @endphp
                            @while ($year != 2015)
                                <option {{ request()->input('year') == $year ? 'selected=selected' : '' }}
                                    value="{{ $year }}">
                                    {{ $year }}</option>
                                @php $year--; @endphp
                            @endwhile
                        </select>
                    </div>

                    <div class='form-group mr-4 w-168'>
                        <select class="form-control bg-light" name="transaction"
                            onchange="document.getElementById('p&LFilterForm').submit();">
                            <option {{ request()->input('transaction') == 'revenue' ? 'selected=selected' : '' }}
                                value="revenue">
                                Revenue</option>
                            <option {{ request()->input('transaction') == 'expenses' ? 'selected=selected' : '' }}
                                value="expenses">
                                Expenses</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        @php
            $currentYear = request()->input('year', now()->year);
            $lastYear = $currentYear - 1;
            $currentYear = substr($currentYear, -2);
            $lastYear = substr($lastYear, -2);
            
        @endphp

        <div style="width: 73em; overflow: scroll;">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Head</th>
                        <th>Particulars</th>
                        <th>Total</th>
                        <th>Apr-{{ $lastYear }} </th>
                        <th>May-{{ $lastYear }}</th>
                        <th>Jun-{{ $lastYear }}</th>
                        <th>Jul-{{ $lastYear }}</th>
                        <th>Aug-{{ $lastYear }}</th>
                        <th>Sep-{{ $lastYear }}</th>
                        <th>Nov-{{ $lastYear }} </th>
                        <th>Dec-{{ $lastYear }}</th>
                        <th>Jan-{{ $currentYear }} </th>
                        <th>Feb-{{ $currentYear }}</th>
                        <th>Mar-{{ $currentYear }}</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>Head</td>
                        <td>Particulars</td>
                        <td>Total</td>
                        <td>Apr-{{ $lastYear }} </td>
                        <td>May-{{ $lastYear }}</td>
                        <td>Jun-{{ $lastYear }}</td>
                        <td>Jul-{{ $lastYear }}</td>
                        <td>Aug-{{ $lastYear }}</td>
                        <td>Sep-{{ $lastYear }}</td>
                        <td>Nov-{{ $lastYear }} </td>
                        <td>Dec-{{ $lastYear }}</td>
                        <td>Jan-{{ $currentYear }} </td>
                        <td>Feb-{{ $currentYear }}</td>
                        <td>Mar-{{ $currentYear }}</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection
