@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <br>
            @include('hr.volunteers.menu')
            <br><br>
        </div>
        <div class="col-md-12">
            @include('status', ['errors' => $errors->all()])
        </div>
        <div class="col-md-12">
            <h1>Volunteering Campaigns</h1>
            
        </div>
        <div class="col-md-12">
            <img src="/images/volunteer-campaigns-min.png" alt="volunteer campaigns" class="w-full">
        </div>
    </div>
    <div class="row">

    </div>
</div>
@endsection
