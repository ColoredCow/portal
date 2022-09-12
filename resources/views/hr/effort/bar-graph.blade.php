@extends('layouts.app')
@section('content')
    @include('hr.employees.sub-views.menu')
    <script type="text/javascript" src="{{ url(mix('/js/app.js')) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>


    <div class="my-2 mx-2" style="background-color: black; color: white;">
        <h3>Efforts of: {{ $employee->name }}</h3>
    </div>
    <div class="container my-2">
        <canvas id="effortChart" height="100px" data-target="{{ $chartData }}"></canvas>
    </div>
@endsection
