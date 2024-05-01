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
            <div class="card-body" >
                <div>
                    <h5 class="max-interview-heading fz-20 d-flex justify-content-between "> Threshold value :
                        <input type="number" class="col-xs text-center outline-none h-40 w-auto rounded-12 quantity" id="quantity" name="employee_earning_threshold" value="{{ old('employee_earning_threshold', $employeeEarningThreshold) }}">
                    </h5> 
                </div>
                <div>
                    <h5 class="max-interview-heading fz-20 d-flex justify-content-between"> contract end date alert (days) :
                        <input type="number" class="col-xs text-center outline-none h-40 w-auto rounded-12 quantity" id="quantity" name="contract_endDate_threshold" value="{{ old('contract_endDate_threshold', $endDateAlert) }}">
                    </h5>        
                </div>
            </div>
                <input type="submit" class="btn btn-primary" value="Save">
        </div>
    </div>
</form>
@endsection
