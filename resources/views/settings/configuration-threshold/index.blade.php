@extends('user::layouts.master')

@section('content')
    <form action="{{ route('settings.update-configuration-threshold') }}" method="POST">
        @csrf
        <div class="container">
            <div class="row justify-content-start">
                <div class="col-6">
                    <label class="user-settings fz-24">Config Variable</label>
                </div>
            </div>
            <div class="col" id="user-settings-content">
                @foreach ($ThresholdValues as $ThresholdValue)
                    <div class="card-body">
                        @if ($ThresholdValue->setting_key === 'employee_earning_threshold')
                            <div>
                                <h5 class="max-interview-heading fz-20 d-flex justify-content-between">Employee Profitability
                                    threshold value :
                                    <input type="number"
                                        class="col-xs text-center outline-none h-40 w-auto rounded-12 quantity"
                                        id="quantity" name="employee_earning_threshold"
                                        value="{{ old('employee_earning_threshold', $ThresholdValue->setting_value) }}">
                                </h5>
                            </div>
                        @elseif ($ThresholdValue->setting_key === 'contract_end_date_threshold')
                            <div>
                                <h5 class="max-interview-heading fz-20 d-flex justify-content-between">Contract End Date
                                    Alert(days):
                                    <input type="number"
                                        class="col-xs text-center outline-none h-40 w-auto rounded-12 quantity"
                                        id="quantity" name="contract_end_date_threshold"
                                        value="{{ old('contract_end_date_threshold', $ThresholdValue->setting_value) }}">
                                </h5>
                            </div>
                        @endif
                    </div>
                @endforeach
                @if (!$ThresholdValues->contains('setting_key', 'employee_earning_threshold'))
                    <div class="card-body">
                        <div>
                            <h5 class="max-interview-heading fz-20 d-flex justify-content-between">Employee Profitability
                                threshold value :
                                <input type="number"
                                    class="col-xs text-center outline-none h-40 w-auto rounded-12 quantity" id="quantity"
                                    name="employee_earning_threshold" value="{{ old('employee_earning_threshold') }}">
                            </h5>
                        </div>
                    </div>
                @endif
                @if (!$ThresholdValues->contains('setting_key', 'contract_end_date_threshold'))
                    <div class="card-body">
                        <div>
                            <h5 class="max-interview-heading fz-20 d-flex justify-content-between">Contract End Date
                                Alert(days):
                                <input type="number"
                                    class="col-xs text-center outline-none h-40 w-auto rounded-12 quantity" id="quantity"
                                    name="contract_end_date_threshold" value="{{ old('contract_end_date_threshold') }}">
                            </h5>
                        </div>
                    </div>
                @endif
                <input type="submit" class="btn btn-primary" value="Save">

            </div>
        </div>
    </form>
@endsection
