@extends('user::layouts.master')

@section('content')

<form action="{{ route('user.settings') }}" method="POST">
@csrf
    <div class="container">
        <div class="row justify-content-around">
            <div class="col-6">
                <label class="user-settings fz-24">User Settings</label>
            </div>
            <div>
                <input type="text" class="form-control search-user-settings" placeholder="Search Settings">
            </div>
        </div>
        <div class="col" id="user-settings-content">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route ('user.settings') }}">HR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Finance(Coming soon)</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <h5 class="max-interview-heading fz-20">Maximum interviews in a day:
                    <input type="number" class="col-xs text-center outline-none h-40 w-68 rounded-12 quantity" id="quantity" name="max_interviews_per_day" min="0" max="10" value="{{ old ('max_interviews_per_day', Auth::user()->metaValue('max_interviews_per_day')) }}">
                </h5>        
                <input type="submit" class="btn btn-primary" value="Save">
            </div>
        </div>
    </div>
</form>
@endsection
