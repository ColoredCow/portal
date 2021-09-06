@extends('user::layouts.master')
@section('content')


<div class="container">
    <div class="col-6">
        <label class="user-settings">User Settings</label>
        <input type="text" class="form-control search" placeholder="Search Settings">
    </div>
    <div class="card-header d33">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link" href="/user/user-settings">HR</a>    
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="true" href="#">Finance</a>        
            </li>
        </ul>
    </div>
    <div class="card-body d2">
        <h5 class="card-title max">Maximum interviews in a day:</h5>
        <input type="number" class="quantity" name="quantity" value=''></input>
    </div>
</div>
