@extends('layouts.app')

@section('content')

<div class="container" >
	<div class="card" style="margin-top: 100px; margin-left: 100px; margin-right: 100px;">
		<div class="card-body">
			<h2 class="text-center text-danger">
				<i class="fa fa-warning"></i>Error - {{ $statusCode }}
			</h2>
			<br>
			<h4 class="text-danger text-center">The server was not able to handle this request.</h4>
		</div>
	</div>
</div>
@endsection
