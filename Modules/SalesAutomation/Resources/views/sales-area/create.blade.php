@extends('salesautomation::layouts.master')

@section('salesautomation.content')
	<h1>New Sales Area</h1>
	<form action="{{ route('sales-area.store') }}" method="POST">
		@csrf
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Name<span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" autofocus required>
						</div>
					</div>
				</div>	
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</form>
@endsection