@extends('layouts.app')
@section('content')
<div class="container">
<div class="row justify-content-center">
<h1>Applications Per Jobs Roles</h1>
</div>
<div>
  <p>Total Count:<span>{{$TotalCount}}</span></p>
</div>
<canvas id="myChart" data-target="{{ $chartData }}" width="120%" height="150px"></canvas>
@endsection