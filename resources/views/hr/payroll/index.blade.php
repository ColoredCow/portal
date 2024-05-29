@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.payroll.menu')
    <br><br>

    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr class="sticky-top">
                <th>{{ __('Name') }}</th>
                <th>{{ __('Current CTC') }}</th>
                <th>{{ __('Previous CTC') }}</th>
                <th>{{ __('% increment') }}</th>
                <th>{{ __('Date of increment') }}</th>
            </tr>
            @foreach ($employees as $employee)
                <tr>
                    @php
                        $user = $employee->user()->withTrashed()->first();
                        $employeeCurrentSalaryObject = $employee->getLatestSalary();
                        $employeePreviousSalaryObject = $employee->getPreviousSalary();
                    @endphp
                    <td>
                        <a href="{{ route('salary.employee', $employee->id) }}">
                            {{ $employee->name }}
                        </a>
                    </td>
                    <td>
                       {{ optional($employeeCurrentSalaryObject)->ctc_aggregated }}
                    </td>
                    <td>
                        {{ optional($employeePreviousSalaryObject)->ctc_aggregated }}
                    </td>
                    <td>
                        {{ $employee->latest_salary_percentage_increment }} %
                    </td>
                    <td>
                        @php
                            $commencementDate = optional($employeeCurrentSalaryObject)->commencement_date;
                            $diff = now()->diff($commencementDate);
                            $diffInDays =  now()->diffInDays($commencementDate);
                            $totalMonths = $diff->y * 12 + $diff->m;
                            $totalDays = $diff->d;
                            $humanReadableTimeDifference = $totalMonths . " months and " . $totalDays . " days";
                        @endphp
                        {{ optional($commencementDate)->format('Y-m-d') }} {{ $diffInDays == 0 ? '(0 days)' : '( ' . $humanReadableTimeDifference . ' )' }}
                    </td>
                </tr>
            @endforeach
    </table>
</div>
@endsection