@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <br>
            @include('hr.menu')
            <br><br>
        </div>
        <div class="col-md-12">
            @include('status', ['errors' => $errors->all()])
        </div>
        <div class="col-md-12">
            <h1>Recruitment Campaigns</h1>
        </div>
        <div class="col-md-12">
            <img src="/images/campaigns-min.png" alt="employee reports" class="w-100">
        </div>
    </div>
    <div class="row">

    </div>
</div>
@endsection
