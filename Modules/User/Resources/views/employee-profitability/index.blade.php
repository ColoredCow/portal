@extends('user::layouts.master')

@section('content')

<form action="{{ route('user.settings') }}" method="POST">
@csrf
    <div class="container">
        <div class="row justify-content-around">
            <div class="col-6">
                <label class="user-settings fz-24">Employee Profitability Threshold value</label>
            </div>
            <div>
                <input type="text" class="form-control search-user-settings" placeholder="Search Settings">
            </div>
        </div>
        <div class="col" id="user-settings-content">
            <div class="card-body">
                <h5 class="max-interview-heading fz-20"> Threshold value
                    <input type="number" class="col-xs text-center outline-none h-40 w-68 rounded-12 quantity" id="quantity" name="max_interviews_per_day" min="0" max="10" value="{{ old ('max_interviews_per_day', Auth::user()->metaValue('max_interviews_per_day')) }}">
                </h5>        
                <input type="submit" class="btn btn-primary" value="Save">
            </div>
        </div>
    </div>
</form>
@endsection
