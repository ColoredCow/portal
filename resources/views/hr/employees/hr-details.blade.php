@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4 class="mb-5 font-weight-bold">HR Details</h4>
            <br>
            @include('hr.employees.sub-views.menu', $employee)
            <br><br>
        </div>
        <div class="col-md-12 text-center">
        <h1>Coming Soon!!</h1>
        </div>
    </div>
</div>
@endsection