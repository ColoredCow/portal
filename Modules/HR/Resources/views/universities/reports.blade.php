@extends('hr::layouts.master')
@section('content')
<div class="container">
<div class="row justify-content-center">
<h1>Applications Per Jobs Roles</h1>
</div>
<div class="d-flex justify-content-between align-items-center m-4">  
	<div>
	  <form action="{{ route('universities.reports',$report = $university->id) }}" method="get">
	  </form>
  </div>
</div>
<canvas id="universityChart" data-target="{{ $universityDataChart }}" width="200%" height="100px"></canvas>
@endsection