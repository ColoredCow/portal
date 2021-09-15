@extends('user::layouts.master')

@section('content')

<form action ="{{ route('user.settings') }}" method = "POST">
@csrf
<div class="container">
    <div class="row justify-content-around">
        <div class="col-6">
            <label class="user-settings">User Settings</label>
        </div>
        <div class=".col-6 .offset-md-3">
            <input type="text" class="form-control search-user-settings" placeholder="Search Settings">
        </div>
    </div>
    <div class="col user-settings-contents">
        <div class= "user-settings-menu">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href = "{{ route ('user.settings') }}">HR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Finance(Coming soon)</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <h5 class="max">Maximum interviews in a day:
                    <input type="number" class="quantity" id="quantity" name="max_interviews_per_day" min="0" max="4" value="{{ old ('max_interviews_per_day', optional(Auth::user()->meta)->max_interviews_per_day) }}">
                </h5>        
                <input type="submit" class="btn btn-secondary save" value="Save">
            </div>    
        </div>
    </div>
</div>
</form>
@endsection
