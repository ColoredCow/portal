@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <br>
            <h1>Hello, {{$employee->name}}</h1>
            <br>
        </div>
        <div class="col-md-12">
            <h2>Welcome<h2>
        </div>
    </div>
</div>
@endsection
