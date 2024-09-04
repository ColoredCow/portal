@extends('salary::layouts.master')
@section('content')
    <div class="container">
        <br>
        @include('hr.employees.sub-views.menu')
        @include('salary::employee.salaryConfirmationModal')
        <br>
        <form action="{{ route('salary.employee.store', $employee) }}" id="employee_salary_form" method="POST"  enctype="multipart/form-data">
            @csrf
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="mt-4 card">
                <div class="card-header pb-lg-5 fz-28">
                    <div class="d-flex justify-content-between mt-4 ml-5">
                        <h4 class="mb-5 font-weight-bold">Employee Salary ( <i class="fa fa-rupee"></i>&nbsp;)</h4>
                        <div>
                            @can('employee_salary.update')
                            <span data-toggle="tooltip" data-placement="top" title="Update the existing entry">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    Update
                                </button>
                            </span>
                            @endcan
                            @can('employee_salary.create')
                            <span data-toggle="tooltip" data-placement="top" title="Create a new salary entry">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#saveAsIncrementModal">
                                    Create Appraisal
                                </button>
                            </span>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to update the salary?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input name="submitType" type="submit" class="btn btn-primary ml-7 px-4" value="Save"/>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mx-5 align-items-end">
                        <h1>{{ $employee->name }}</h1>
                        @if (optional($employee->user()->withTrashed())->first()->avatar)
                            <span class="content tooltip-wrapper" data-html="true" data-toggle="tooltip"
                                title="{{ $employee->name }}">
                                <img src="{{ $employee->user()->withTrashed()->first()->avatar }}"
                                    class="w-100 h-100 rounded-circle">
                            </span>
                        @endif
                    </div>
                    <hr class='bg-dark mx-4 pb-0.5'>
                    <br>
                    <div class="d-md-flex">
                        <div class="form-group col-md-5">
                            <label class="leading-none fz-24 ml-4 d-flex align-items-center" for="grossSalary">
                                <span class="mr-1 mb-1">{{ __('Monthly Gross Salary') }}</span>
                                <span><i class="fa fa-rupee"></i></span>
                            </label>
                            <input v-model="grossSalary" type="number" step="0.01" name="grossSalary" id="grossSalary" class="form-control ml-4 bg-light" placeholder="Enter Monthly Gross Salary" min="0" required>
                        </div>
                        <div class="form-group col-md-5">
                            <label class="leading-none fz-24 ml-4 d-flex align-items-center" for="commencementDate">
                                <span class="mr-1 mb-1">{{ __('Commencement Date') }}</span>
                            </label>
                            <input v-model="commencementDate" type="date" name="commencementDate" id="commencementDate" class="form-control ml-4 bg-light" required>
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div class="form-group col-md-5">
                            <label class="leading-none fz-24 ml-4 d-flex align-items-center" for="tds">
                                <span class="mr-1 mb-1">{{ __('TDS') }}</span>
                                <span><i class="fa fa-rupee"></i></span>
                            </label>
                            <input v-model="tds" type="number" step="0.01" name="tds" id="tds" class="form-control ml-4 bg-light" placeholder="Enter TDS" min="0" required>
                        </div>
                    </div>
                    <br>
                    <div class="form-group col-md-12">
                        <div class="ml-4">
                            <salary-breakdown
                                :salary-configs="{{ json_encode($salaryConfigs) }}"
                                :insurance-tenants="{{ optional($employee->user->profile)->insurance_tenants ?: 1 }}"
                                :gross-salary="grossSalary"
                                :tds="{{ optional($employee->getLatestSalary())->tds ?: 0  }}"
                                :commencement-date="commencementDate"
                                :loan-deduction="{{ $employee->loan_deduction_for_month ?: 0 }}"
                            ></salary-breakdown>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js_scripts')
    <script>
        new Vue({
            el: '#employee_salary_form',
            data() {
                return {
                    tds: "{{ optional($employee->getLatestSalary())->tds ?: 0 }}",
                    grossSalary: "{{ optional($employee->getLatestSalary())->monthly_gross_salary }}",
                    commencementDate: "{{ optional(optional($employee->getLatestSalary())->commencement_date)->format('Y-m-d') }}",
                }
            }
        });
    </script>
@endsection
