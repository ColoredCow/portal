@extends('hr::layouts.master')
@section('content')
<div class="container">
	<a href="{{ route('universities.index') }}" class="text-theme-body text-decoration-none mb-2 mb-xl-4 align-items-center">
        <span class="mr-1 d-inline-flex w-8 h-8 w-xl-12 h-xl-12">
            {!! file_get_contents(public_path('icons/prev-icon.svg')) !!}
        </span>
        <span>Universities</span>
    </a>
<div class="row justify-content-center">
<h1>Applications Per Jobs Roles</h1>
</div>
<div class="d-flex justify-content-between align-items-center m-4">  
	<div>
	  <a href="{{ route('hr.universities.reports.show', $university) }}">
	  </a>
  </div>
</div>
<canvas id="universityChart" data-target="{{ $universityDataChart }}" width="200%" height="100px"></canvas>
@endsection