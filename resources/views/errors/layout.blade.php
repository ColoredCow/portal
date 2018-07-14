@extends('layouts.app')

@section('content')
<div class="container" >
	<div class="d-flex justify-content-center">
		<div class="card">
			<div class="card-header">
				<h2 class="text-center text-danger"><i class="fa fa-warning"></i> @yield('error_title')</i></h2>
			</div>
			<div class="card-body">
				<h4 class="text-secondary text-center">@yield('error_message')</h4>
			</div>
		</div>
	</div>
</div>
@endsection
