@extends('user::layouts.master')

@section('content')

<form action="{{ route('settings.update-profitability-threshold-value') }}" method="POST">
@csrf
    <div class="container">
        <div class="row justify-content-start">
            <div class="col-6">
                <label class="user-settings fz-24">Config Variable</label>
            </div>
        </div>
        <div class="col" id="user-settings-content">
            <div class="card-body">
                <h5 class="max-interview-heading fz-20"> Threshold value
                <input type="number" class="col-xs text-center outline-none h-40 w-auto rounded-12 quantity" id="quantity" name="profitability_threshold_value" value="{{ old('profitability_threshold_value', $profitabilityThreshold) }}">
                </h5>        
                <input type="submit" class="btn btn-primary" value="Save">
            </div>
        </div>
    </div>
</form>
@endsection
