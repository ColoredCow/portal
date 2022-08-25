@extends('report::layouts.master')
@section('content')
    <div class="container" id="vueContainer">
        <br>
        <br>

        <div class="d-flex justify-content-between mb-2">
            <h4 class="mb-1 pb-1"> Profit and Loss Report</h4>
            {{-- ToDo:: we need to enable this when we add export funcationality done in the backend. --}}
            <span>
                <a href="" class="btn disabled btn-info text-white"> Export To Excel </a>
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
                            @php
                                $startYear = $currentYear;
                            @endphp

                            @while ($startYear != 2015)
                                <option value="{{ $startYear }}"
                                    {{ request()->input('year') == $startYear ? 'selected' : '' }}>
                                    {{ $startYear - 1 }} - {{ $startYear }}
                                </option>
                                @php
                                    $startYear--;
                                @endphp
                            @endwhile
                        </select>
                    </div>

                    <div class='form-group mr-4 w-168'>
                        <select class="form-control bg-light" name="transaction"
                            onchange="document.getElementById('p&LFilterForm').submit();">
                            <option {{ request()->input('transaction') == 'revenue' ? 'selected=selected' : '' }}
                                value="revenue">
                                Revenue</option>
                            <option disabled
                                {{ request()->input('transaction') == 'expenses' ? 'selected=selected' : '' }}
                                value="expenses">
                                Expenses</option>

                            <option disabled {{ request()->input('transaction') == 'taxes' ? 'selected=selected' : '' }}
                                value="texes">
                                Taxes</option>

                            <option disabled {{ request()->input('transaction') == 'taxes' ? 'selected=selected' : '' }}
                                value="overall">
                                Overall</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        @php
            $lastYear = $currentYear - 1;
            $currentYearVal = substr($currentYear, -2);
            $lastYearVal = substr($lastYear, -2);
            
        @endphp

        <div>
            <table class="table table-bordered table-responsive">
                <thead class="thead-dark">
                    <tr>
                        <th>Head</th>
                        <th>Particulars</th>
                        <th>Total</th>
                        <th>Apr-{{ $lastYearVal }} </th>
                        <th>May-{{ $lastYearVal }}</th>
                        <th>Jun-{{ $lastYearVal }}</th>
                        <th>Jul-{{ $lastYearVal }}</th>
                        <th>Aug-{{ $lastYearVal }}</th>
                        <th>Sep-{{ $lastYearVal }}</th>
                        <th>Oct-{{ $lastYearVal }}</th>
                        <th>Nov-{{ $lastYearVal }} </th>
                        <th>Dec-{{ $lastYearVal }}</th>
                        <th>Jan-{{ $currentYearVal }} </th>
                        <th>Feb-{{ $currentYearVal }}</th>
                        <th>Mar-{{ $currentYearVal }}</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($reportData as $perticular)
                        <tr>
                            <td>{{ $perticular['head'] }}</td>
                            <td>{{ $perticular['name'] }}</td>
                            <td>{{ $perticular['amounts']['total'] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["04-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["05-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["06-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["07-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["08-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["09-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["10-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["11-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["12-$lastYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["01-$currentYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["02-$currentYearVal"] ?? 0 }}</td>
                            <td>{{ $perticular['amounts']["03-$currentYearVal"] ?? 0 }}</td>
                        </tr>
                    @endforeach

                    <tr class="bg-info">

                        <td colspan="2">Total Revenue </td>
                        <td>{{ array_sum(array_column($allAmounts, 'total')) }}</td>
                        <td>{{ array_sum(array_column($allAmounts, "04-$lastYearVal")) }}</td>
                        <td>{{ array_sum(array_column($allAmounts, "05-$lastYearVal")) }}</td>
                        <td>{{ array_sum(array_column($allAmounts, "06-$lastYearVal")) }}</td>
                        <td>{{ array_sum(array_column($allAmounts, "07-$lastYearVal")) }}</td>
                        <td>{{ array_sum(array_column($allAmounts, "08-$lastYearVal")) }}</td>
                        <td>{{ array_sum(array_column($allAmounts, "09-$lastYearVal")) }}</td>
                        <td>{{ array_sum(array_column($allAmounts, "10-$lastYearVal")) }}</td>
                        <td>{{ array_sum(array_column($allAmounts, "11-$lastYearVal")) }}</td>
                        <td>{{ array_sum(array_column($allAmounts, "12-$lastYearVal")) }}</td>
                        <td>{{ array_sum(array_column($allAmounts, "01-$currentYearVal")) }}</td>
                        <td>{{ array_sum(array_column($allAmounts, "02-$currentYearVal")) }}</td>
                        <td>{{ array_sum(array_column($allAmounts, "03-$currentYearVal")) }}</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection
