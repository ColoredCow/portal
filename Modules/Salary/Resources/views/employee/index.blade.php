@extends('salary::layouts.master')
@section('content')
    <div class="container" id="employee_salary_form">
        <br>
        @include('hr.employees.sub-views.menu')
        <br>
        <form action="{{ route('salary.employee.store', $employee) }}" method="POST">
            @csrf
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="mt-4 card">
                <div class="card-header pb-lg-5 fz-28">
                    <div class="d-flex justify-content-between mt-4 ml-5">
                        <div>
                            Employee Salary ( <i class="fa fa-rupee"></i>&nbsp;)
                        </div>
                        <div>
                            <span data-toggle="tooltip" data-placement="top" title="Update the existing entry">
                                <input name="submitType" type="submit" class="btn btn-primary ml-7 px-4" value="Update"/>
                            </span>
                            <span data-toggle="tooltip" data-placement="top" title="Create a new salary entry">
                                <input name="submitType" type="submit" class="btn btn-primary ml-2 px-4" value="Save as Increment"/>
                            </span>
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
                            <label class="leading-none fz-24 ml-4 d-flex align-items-center" for="grossSalary">
                                <span class="mr-1 mb-1">{{ __('Commencement Date') }}</span>
                            </label>
                            <input v-model="commencementDate" type="date" name="commencementDate" id="commencementDate" class="form-control ml-4 bg-light" required>
                        </div>
                    </div>
                    <br>
                    <div class="form-group col-md-12">
                        <div class="ml-4">
                            <salary-breakdown
                                :salary-configs="{{ json_encode($salaryConfigs) }}"
                                :gross-salary="grossSalary"
                                :commencement-date="commencementDate"
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
                    grossSalary: "{{ optional($employee->getCurrentSalary())->monthly_gross_salary }}",
                    commencementDate: "{{ optional(optional($employee->getCurrentSalary())->commencement_date)->format('Y-m-d') }}"
                }
            }
        });
    </script>
@endsection
