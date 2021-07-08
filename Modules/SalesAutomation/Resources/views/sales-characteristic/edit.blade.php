@extends('salesautomation::layouts.master')

@section('salesautomation.content')
	<h1>Edit Sales Characteristic</h1>
	<form action="{{ route('sales-characteristic.update', $salesCharacteristic) }}" method="POST">
		@csrf
		@method('PUT')
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Name<span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="name" id="name" value="{{ old('name', $salesCharacteristic->name) }}" autofocus required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="type">Type<span class="text-danger">*</span></label>
							<select name="type" id="type" class="form-control" required>
								@foreach (config('salesautomation.sales-characteristic.types') as $type => $label)
									@php
										$selected = $type == old('type', $salesCharacteristic->type) ? 'selected' : '';
									@endphp
									<option value="{{ $type }}" {{ $selected }}>{{ $label }}</option>
								@endforeach
							</select>
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