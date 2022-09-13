@extends('layouts.app')
@section('content')
    @include('hr.employees.sub-views.menu')

    <div class="my-2 mx-2" style="background-color: #1a0000; color: #ffe6e6;">
        <h3>Efforts of: {{ $employee->name }}</h3>
    </div>
    <div class="container my-2">
        <canvas id="effortChart" height="100px" data-target="{{ $chartData }}"></canvas>
    </div>
@endsection
