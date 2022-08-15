@extends('layouts.app')
@section('content')
<div class="container">
<div class="row justify-content-center">
<h1>Applications Per Jobs Roles</h1>
</div>
<div class="d-flex justify-content-between align-items-center m-4">
  <p>Total Count: <span>{{$totalCount}}</span></p>
  <div>
	  <form class="form-inline text-right" action="{{route('applications.job-Wise-Applications-Graph')}}" method="get">
		<div class="form-group">
		<input type="date" name="start_date" id="start_date" class="form-control-sm" required> 
		</div>
		<span class="mx-2">to</span>
		<div class="form-group">
		<input type="date" name="end_date" id="end_date" class="form-control-sm" required>
		</div>
		<div class="form-group">
		<button class="btn btn-primary btn-sm ml-2" type="submit">View</button>
		</div>
	  </form>
  </div>
</div>
<canvas id="myChart" data-target="{{ $chartData }}" width="120%" height="150px"></canvas>
@endsection