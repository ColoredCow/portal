@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <br>
            @include('hr.employees.menu')
            <br><br>
        </div>
        <div class="col-md-12">
            @include('status', ['errors' => $errors->all()])
        </div>
        <div class="col-md-12">
            <h1 class="mb-2">{{ $employee->name }}</h1>
        </div>
        <div class="col-md-12">
            <img src="/images/employee-details.png" alt="employee details" style="width: 82%;">
            {{-- <img src="/images/employee-details-min.png" alt="employee details"> --}}
        </div>
    </div>
    <div class="row">

    </div>
</div>
@endsection
