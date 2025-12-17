@extends('salary::layouts.master')
@section('content')
    <div class="container">
        <br>
        @include('hr.employees.sub-views.menu')
        <br>
        <form action="{{ route('salary.contractor.store', $employee) }}" id="contractor_salary_form" method="POST"  enctype="multipart/form-data">
            @csrf
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="mt-4 card">
                <div class="card-header pb-lg-5 fz-28">
                    <div class="d-flex justify-content-between mt-4 ml-5">
                        <h4 class="mb-5 font-weight-bold">Contractor Fee ( <i class="fa fa-rupee"></i>&nbsp;)</h4>
                        <div>
                            @can('employee_salary.update')
                            <span data-toggle="tooltip" data-placement="top" title="Update the existing entry">
                                <input name="submitType" type="submit" class="btn btn-primary ml-7 px-4" value="Update"/>
                            </span>
                            @endcan
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
                            <label class="leading-none fz-24 ml-4 d-flex align-items-center" for="contractorFee">
                                <span class="mr-1 mb-1">{{ __('Monthly Fee') }}</span>
                                <span><i class="fa fa-rupee"></i></span>
                            </label>
                            <input type="number" step="0.01" value="{{ optional($salary)->monthly_fee }}" name="contractorFee" id="contractorFee" onkeyup="onUpdateMonthlyFee(this.value)" class="form-control ml-4 bg-light" placeholder="Enter Contractor Fee" min="0" required>
                        </div>
                        <div class="form-group col-md-5">
                            <label class="leading-none fz-24 ml-4 d-flex align-items-center" for="commencementDate">
                                <span class="mr-1 mb-1">{{ __('Commencement Date') }}</span>
                            </label>
                            <input type="date" name="commencementDate" value="{{ optional(optional($salary)->commencement_date)->format('Y-m-d') }}" id="commencementDate" class="form-control ml-4 bg-light" required>
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div class="form-group col-md-5">
                            <label class="leading-none fz-24 ml-4 d-flex align-items-center" for="tds">
                                <span class="mr-1 mb-1">{{ __('TDS') }}</span>
                                <span><i class="fa fa-rupee"></i></span>
                            </label>
                            <input v-model="tds" value="{{ optional($salary)->tds }}" type="number" step="0.01" name="tds" id="tds" class="form-control ml-4 bg-light" placeholder="Enter TDS" min="0" required>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js_scripts')
    <script>
        function onUpdateMonthlyFee(value) {
            var tds = document.getElementById('tds')
            tds.value = Math.floor(value * 0.02)
        }
    </script>
@endsection
