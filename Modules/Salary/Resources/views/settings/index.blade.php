@extends('salary::layouts.master')

@section('content')
    <div class="container">
        <h4>Salary Settings</h4>
        <br>
        <form action="{{ route('salary-settings.update') }}" method="POST">
            @csrf
            @include('status', ['errors' => $errors->all()])
            @includeWhen(session('success'), 'toast', ['message' => session('success')])
            <div class="card">
                <div class="card-body">
                    <div class="row mb-6">
                        <div class="col-12">
                            <h4 class="text-underline">Based on gross salary</h4>
                            <br>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Basic Salary</label>
                                    <div class="input-group">
                                        <input style="flex-grow: 0.2;" name="basic_salary[rate]" type="number"
                                            class="form-control w-10" placeholder="%"
                                            value="{{ optional($salaryConfig->get('basic_salary', null))->percentage_rate }}" step="0.01">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">% of gross salary</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Employer ESI</label>
                                    <div class="input-group">
                                        <input style="flex-grow: 0.2;" name="employer_esi[rate]" type="number"
                                            class="form-control w-10"
                                            value="{{ optional($salaryConfig->get('employer_esi', null))->percentage_rate }}"
                                            placeholder="%" step="0.01">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">% of gross salary</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <h5 class="mt-2 mb-3 text-underline">Deductions based on gross salary</h5>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Employee ESI</label>
                                    <div class="input-group">
                                        <input style="flex-grow: 0.2;" name="employee_esi[rate]" type="number"
                                            class="form-control w-10" placeholder="%"
                                            value="{{ optional($salaryConfig->get('employee_esi', null))->percentage_rate }}" step="0.01">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">% of gross salary</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <div class="col-12">
                            <h4 class="text-underline">Based on basic salary</h4>
                            <br>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>HRA</label>
                                    <div class="input-group">
                                        <input style="flex-grow: 0.2;" name="hra[rate]" type="number"
                                            class="form-control w-10" placeholder="%"
                                            value="{{ optional($salaryConfig->get('hra', null))->percentage_rate }}" step="0.01">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">% of basic salary</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>EPF employer share</label>
                                    <div class="input-group">
                                        <input style="flex-grow: 0.2;" name="employer_epf[rate]" type="number"
                                            class="form-control w-10"
                                            value="{{ optional($salaryConfig->get('employer_epf', null))->percentage_rate }}"
                                            placeholder="%" step="0.01">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">% of basic salary</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Administration charges</label>
                                    <div class="input-group">
                                        <input style="flex-grow: 0.2;" name="administration_charges[rate]" type="number"
                                            class="form-control w-10" placeholder="%"
                                            value="{{ optional($salaryConfig->get('administration_charges', null))->percentage_rate }}" step="0.01">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">% of basic salary</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>EDLI charges FIXED</label>
                                    <div class="input-group">
                                        <input style="flex-grow: 0.2;" name="edli_charges[rate]" type="number"
                                            class="form-control w-10" placeholder="%"
                                            value="{{ optional($salaryConfig->get('edli_charges', null))->percentage_rate }}" step="0.01">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">% of basic salary</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <h5 class="mt-2 mb-3 text-underline">Deductions based on basic salary</h5>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Employee EPF</label>
                                    <div class="input-group">
                                        <input style="flex-grow: 0.2;" name="employee_epf[rate]" type="number"
                                            value="{{ optional($salaryConfig->get('employee_epf', null))->percentage_rate }}"
                                            class="form-control w-10" placeholder="%" step="0.01">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">% of basic salary</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-underline">Fixed amounts</h4>
                            <br />
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label>Transport allowance</label>
                                    <input name="transport_allowance"
                                        value="{{ optional($salaryConfig->get('transport_allowance', null))->fixed_amount }}"
                                        type="number" class="form-control"
                                        placeholder="amount" step="0.01">
                                </div>
                                <div class="form-group offset-md-1 col-md-5">
                                    <label>Food allowance </label>
                                    <input name="food_allowance"
                                        value="{{ optional($salaryConfig->get('food_allowance', null))->fixed_amount }}"
                                        type="number" class="form-control"
                                        placeholder="amount" step="0.01">
                                </div>
                                <div class="form-group col-md-5">
                                    <label>Employee ESI limit</label>
                                    <input name="employee_esi_limit" type="number"
                                        class="form-control"
                                        value="{{ optional($salaryConfig->get('employee_esi_limit', null))->fixed_amount }}"
                                        placeholder="amount" step="0.01">
                                    <small class="help-text text-muted fz-14">If the gross salary will be higher then this limit, then ESI will not be applicable. Leave null if you want to apply on all the employees.
                                    </small>
                                </div>
                                <div class="form-group offset-md-1 col-md-5">
                                    <label>Employer ESI limit</label>
                                    <input name="employer_esi_limit" type="number"
                                        class="form-control"
                                        value="{{ optional($salaryConfig->get('employer_esi_limit', null))->fixed_amount }}"
                                        placeholder="amount" step="0.01">
                                    <small class="help-text text-muted fz-14">If the gross salary will be higher then this limit, then ESI will not be applicable. Leave null if you want to apply on all the employees.
                                    </small>
                                </div>
                                <div class="form-group col-md-5">
                                    <label>EDLI maximum salary limit</label><br>
                                    <input
                                        value="{{ optional($salaryConfig->get('edli_charges_limit', null))->fixed_amount }}" name="edli_charges_limit" type="number"
                                        class="form-control" placeholder="amount" step="0.01">
                                    <small class="help-text text-muted fz-14">If the basic salary will be high with this limit then this amount will be considered for calculations.Leave empty if you want to apply on all the amount.</small>
                                </div>
                                <div class="form-group offset-md-1 col-md-5">
                                    <label>Health Insurance</label>
                                    <input name="health_insurance"
                                        value="{{ optional($salaryConfig->get('health_insurance', null))->fixed_amount }}"
                                        type="number" class="form-control"
                                        placeholder="amount" step="0.01">
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
