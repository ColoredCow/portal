@extends('layouts.app')

@section('content')
<div class="container" >
	<div class="d-flex justify-content-center">
		<div class="card">
			<div class="card-body">
				<h2 class="text-center text-danger">
					<i class="fa fa-warning"></i>Error - {{ $statusCode }}
				</h2>
				<br>
				<h4 class="text-danger text-center">The server was not able to handle this request.</h4>
			</div>
		</div>
	</div>
</div>
@endsection
