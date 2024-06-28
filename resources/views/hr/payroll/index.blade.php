@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.payroll.menu')
    <br><br>
    <div class="modal fade" id="sendPayrollMailModal" tabindex="-1" role="dialog"
        aria-labelledby="payrollModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-secondary">Send Payroll Mail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('payroll-list-mail') }}" method="POST">
                        @csrf
                        <div class="form-group col-md-12">
                            <label class="leading-none" for="to">
                                {{ __('Recipient Name') }} 
                            </label>
                            <input type="text" name="name" id="to" placeholder="Enter Name" class="form-control" value="{{ config('invoice.ca-email.name') }}" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="leading-none" for="to">
                                {{ __('Recipient Email') }} 
                            </label>
                            <input type="email" name="to" id="to" class="form-control" value="{{ config('invoice.ca-email.email') }}" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="leading-none" for="cc">
                                {{ __('CC Emails') }} 
                                <span data-toggle="tooltip" data-placement="right" title="Comma separated emails">
                                    <i class="fa fa-question-circle"></i>
                                </span>
                            </label>
                            <input type="text" name="cc" id="cc" class="form-control" value="">
                        </div>
                        <input hidden id="payrollMailSubmitButton"  type="submit">
                    </form>
                    <form method="POST" target="_blank" action="{{ route('payroll-download') }}">
                        @csrf
                        @php
                            $employeeExportFilename = 'Salary Computations_' . date('M') . ' ' . date('Y') . '.xlsx';
                            $contractorExportFilename = 'ConsultantFee_Computation_' . date('M') . '_' .  date('Y') . '.xlsx';
                        @endphp
                        <div class="ml-2.5">
                            <div>
                                <label class="leading-none" for="to">
                                    {{ __('Attached Files') }} 
                                </label>
                            </div>
                            <div class="mb-1">
                                <button type="submit" name="export" value="full-time" class="badge badge-sm badge-secondary">{{ $employeeExportFilename }}</button>
                            </div>
                            <div>
                                <button type="submit" name="export" value="contractor" class="badge badge-sm badge-secondary">{{ $contractorExportFilename }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-secondary"
                        data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" onclick="document.getElementById('payrollMailSubmitButton').click()" value="Send">
                </div>
            </div>
        </div>
    </div>

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
                        $employeePreviousSalaryObject = $employee->getPreviousSalary(optional($employeeCurrentSalaryObject)->salary_type);
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