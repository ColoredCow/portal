@extends('user::layouts.master')
@section('content')

<form action ="{{ route('user.settings') }}" method = "POST">
@csrf
<div class="container">
    <div class="col-6">
        <label class="user-settings">User Settings</label>
        <input type="text" class="form-control search" placeholder="Search Settings">
    </div>
    <div class="card-header d33">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link" href="{{ route ('user.settings') }}">HR</a>  
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" aria-current="true" href="#">Finance(coming soon)</a>     
            </li>
        </ul>
    </div>
    <div class="card-body d2" id="body">
        <h5 class="card-title max">Maximum interviews in a day:</h5>
            <input type="number" class="quantity" id="quantity" name="max_interviews_per_day" min="0" max="4" value="{{ old ('max_interviews_per_day', optional(Auth::user()->meta)->max_interviews_per_day) }}"></input>
            <input type="submit" class="btn btn-secondary save" value="Save">
    </div>
</div>
</form>

