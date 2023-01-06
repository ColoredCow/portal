@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.employees.sub-views.menu', $employee)
    <br><br>
    <div class= "card">
        <div class="card-body">
            @include('user::profile.show-basic-details',['user'=>$employee->user])
        </div>
    </div>
</div>
@endsection
