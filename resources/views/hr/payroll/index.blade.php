@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.payroll.menu')
    <br><br>

    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr class="sticky-top">
                <th>Name</th>
                <th>Current CTC</th>
                <th>
                    Previous CTC
                    <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="Total FTE for the current month">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                    </span>
                </th>
                <th>% increment</th>
                <th>Date of increment</th>
            </tr>
            @foreach ($employees as $employee)
                <tr>
                    @php
                        $user = $employee->user()->withTrashed()->first();
                        $totalFTE = $user->ftes['main'] + $user->ftes['amc']
                    @endphp
                    <td>
                        <a href="{{ route('employees.show', $employee->id) }}">
                            @if ($employee->overall_status === 'pending' && $filters['status'] == 'current')
                                {{ $employee->name }} <span
                                    class="{{ config('constants.review-tags.pending.class') }} badge-pill mr-1 mb-1">{{ config('constants.review-tags.pending.title') }}</span>
                            @elseif ($employee->overall_status === 'in-progress' && $filters['status'] == 'current')
                                {{ $employee->name }} <span
                                    class="{{ config('constants.review-tags.in-progress.class') }} badge-pill mr-1 mb-1">{{ config('constants.review-tags.in-progress.title') }}</span>
                            @elseif ($employee->overall_status === 'completed' && $filters['status'] == 'current')
                                {{ $employee->name }} <span
                                    class="{{ config('constants.review-tags.completed.class') }} badge-pill mr-1 mb-1">{{ config('constants.review-tags.completed.title') }}</span>
                            @else
                                {{ $employee->name }}
                            @endif
                        </a>
                    </td>
                    <td>
                        @if ($employee->user == null)
                            0
                        @else
                            {{ $employee->active_project_count }}
                        @endif
                    </td>
                    <td class={{ $totalFTE > 1 ? 'text-success' : 'text-danger' }}>
                        {{ $totalFTE }}
                    </td>
                    <td>
                        <span class="text-success">
                            {{ $user->total_hours['billable'] }}
                        </span>
                    </td>
                    <td>
                        <span class="text-secondary">
                            {{ $user->total_hours['non_billable'] }}
                        </span>
                    </td>
                </tr>
            @endforeach
    </table>
</div>
@endsection