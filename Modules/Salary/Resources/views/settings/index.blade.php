@extends('salary::layouts.master')

@section('content')
    <div class="container">
        <h4>Salary Settings</h4>
        <br>
        <form action="{{ route('salary-settings.update') }}" method="POST">
            @csrf
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
            @endif
            <br>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="text-underline">Based on Gross Salary</h4>
                            <br>
                            <div class="form-group">
                                <label for="">Basic Salary</label>
                                <div class="input-group mb-3">
                                    <input style="flex-grow: 0.2;" name="basic_salary[rate]" type="number"
                                        class="form-control w-10" placeholder="%"
                                        value="{{ optional($salaryConfig->get('basic_salary', null))->percentage_rate }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">% of gross salary</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Medical allowance</label>
                                <div class="input-group mb-3">
                                    <input style="flex-grow: 0.2;" name="medical_allowance[rate]" type="number"
                                        value="{{ optional($salaryConfig->get('medical_allowance', null))->percentage_rate }}"
                                        class="form-control w-10" placeholder="%">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">% of gross salary</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Employee ESI</label>
                                <div class="input-group mb-3">
                                    <input style="flex-grow: 0.2;" name="employee_esi[rate]" type="number"
                                        class="form-control w-10" placeholder="%"
                                        value="{{ optional($salaryConfig->get('employee_esi', null))->percentage_rate }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">% of gross salary</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Employer ESI</label>
                                <div class="input-group mb-3">
                                    <input style="flex-grow: 0.2;" name="employer_esi[rate]" type="number"
                                        class="form-control w-10"
                                        value="{{ optional($salaryConfig->get('employer_esi', null))->percentage_rate }}"
                                        placeholder="%">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">% of gross salary</span>
                                    </div>
                                </div>
                            </div>


                            <h4 class="text-underline">Fixed amounts</h4>
                            <div class="form-group">
                                <label for="">Transport allowance </label>
                                <div class="input-group mb-3">
                                    <input name="transport_allowance"
                                        value="{{ optional($salaryConfig->get('transport_allowance', null))->fixed_amount }}"
                                        type="number" style="flex-grow: 0.5;" class="form-control w-10"
                                        placeholder="Enter Transport Allowance ">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Food allowance </label>
                                <div class="input-group mb-3">
                                    <input name="food_allowance"
                                        value="{{ optional($salaryConfig->get('food_allowance', null))->fixed_amount }}"
                                        type="number" style="flex-grow: 0.5;" class="form-control w-10"
                                        placeholder="Enter Food Allowance Amount">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Employee ESI Limit</label>
                                <span class="help-text text-muted fz-14">If the gross salary will be high with this limit
                                    then ESI
                                    will not
                                    be applicable. Leave null if you want to apply on all the employees </span>
                                <div class="input-group mb-3">
                                    <input style="flex-grow:0.5;" name="employee_esi_limit" type="number"
                                        class="form-control w-10"
                                        value="{{ optional($salaryConfig->get('employee_esi_limit', null))->fixed_amount }}"
                                        placeholder="amount">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">EDLI Maximun salary limit</label><br>
                                <span class="help-text text-muted fz-14">If the basic salary will be high with this
                                    limit
                                    then this amount will be considered for calculations.Leave empty if you want to
                                    apply on
                                    all the amount </span>
                                <div class="input-group mb-3">
                                    <input
                                        value="{{ optional($salaryConfig->get('edli_charges_limit', null))->fixed_amount }}"
                                        style="flex-grow: 0.5;" name="edli_charges_limit" type="number"
                                        class="form-control w-10" placeholder="amount">
                                </div>
                            </div>

                        </div>

                        <div class="col-6">
                            <h4 class="text-underline">Based on Basic Salary</h4>
                            <br>

                            <div class="form-group">
                                <label for="">HRA</label>
                                <div class="input-group mb-3">
                                    <input style="flex-grow: 0.2;" name="hra[rate]" type="number"
                                        class="form-control w-10" placeholder="%"
                                        value="{{ optional($salaryConfig->get('hra', null))->percentage_rate }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">% of basic salary</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Employee EPF</label>
                                <div class="input-group mb-3">
                                    <input style="flex-grow: 0.2;" name="employee_epf[rate]" type="number"
                                        value="{{ optional($salaryConfig->get('employee_epf', null))->percentage_rate }}"
                                        class="form-control w-10" placeholder="%">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">% of basic salary</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">EPF employer share</label>
                                <div class="input-group mb-3">
                                    <input style="flex-grow: 0.2;" name="employer_epf[rate]" type="number"
                                        class="form-control w-10"
                                        value="{{ optional($salaryConfig->get('employer_epf', null))->percentage_rate }}"
                                        placeholder="%">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">% of basic salary</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Administration charges</label>
                                <div class="input-group mb-3">
                                    <input style="flex-grow: 0.2;" name="administration_charges[rate]" type="number"
                                        class="form-control w-10" placeholder="%"
                                        value="{{ optional($salaryConfig->get('administration_charges', null))->percentage_rate }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">% of basic salary</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">EDLI Charges FIXED</label>
                                <div class="input-group mb-3">
                                    <input style="flex-grow: 0.2;" name="edli_charges[rate]" type="number"
                                        class="form-control w-10" placeholder="%"
                                        value="{{ optional($salaryConfig->get('edli_charges', null))->percentage_rate }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">% of basic salary</span>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection
