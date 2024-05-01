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
                @foreach ($configsData as $configData)
                    <div class="card-body">
                        @if ($configData->setting_key === 'employee_earning_threshold')
                            <div>
                                <h5 class="max-interview-heading fz-20 d-flex justify-content-between">Employee Profitability
                                    threshold value :
                                    <input type="number"
                                        class="col-xs text-center outline-none h-40 w-auto rounded-12 quantity"
                                        id="quantity" name="employee_earning_threshold"
                                        value="{{ old('employee_earning_threshold', $configData->setting_value) }}">
                                </h5>
                            </div>
                        @elseif ($configData->setting_key === 'contract_endDate_threshold')
                            <div>
                                <h5 class="max-interview-heading fz-20 d-flex justify-content-between">Contract End Date Alert(days):
                                    <input type="number"
                                        class="col-xs text-center outline-none h-40 w-auto rounded-12 quantity"
                                        id="quantity" name="contract_endDate_threshold"
                                        value="{{ old('contract_endDate_threshold', $configData->setting_value) }}">
                                </h5>
                            </div>
                        @endif
                    </div>
                @endforeach
                <input type="submit" class="btn btn-primary" value="Save">

            </div>
        </div>
    </form>
@endsection
