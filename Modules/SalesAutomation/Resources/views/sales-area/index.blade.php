@extends('salesautomation::layouts.master')

@section('salesautomation.content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<!-- Button trigger modal -->
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<div class="row">
		<div class="offset-md-9 col-md-3 text-right mb-3">
			<a href="{{ route('sales-area.create') }}" class="btn btn-primary">New Sales Area</a>
		</div>
	</div>
	<table class="table table-striped table-bordered">
		<thead class="thead-dark">
		    <tr>
		      <th scope="col">Name</th>
		      <th scope="col">Actions</th>
		    </tr>
		    <tbody>
				
			@foreach ($salesAreas as $salesArea)
			    
					<tr>
						<td>{{ $salesArea->name }}</td>
						<td class="w-25p">
							<i id="modal" class="fa fa-pencil mr-2 c-pointer text-primary" ></i>
							
<div class="modal fade" id="editSalesAreaModal" aria-labelledby="editSalesAreaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	<form action ="{{route('sales-area.update',$salesArea)}}"id="modalform" method="POST"  >
	@csrf
		@method('PUT')
      <div class="modal-header">
        <h5 class="modal-title" id="editSalesAreaLabel">Edit Sales Area</h5>
        <button type="button"  class="btn-close" id="close" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <h1></h1>
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Name<span class="text-danger">*</span></label>
							<input type="text" class="form-control" name="name"  value="{{ old('name', $salesArea->name) }}" autofocus required>
						</div>
					</div>
				</div>	
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</div>
	
      </div>
</form>
      </div>
    </div>
</div>
						<span class="mr-2 text-danger c-pointer" onclick="if(confirm('Are you sure you want to delete?'))document.getElementById('deleteSalesArea-{{ $salesArea->id }}').submit();"><i class="fa fa-trash"></i></span>
							<form action="{{ route('sales-area.destroy', $salesArea) }}" method="POST" id="deleteSalesArea-{{ $salesArea->id }}">
								@csrf
								@method('DELETE')
							</form>
						</td>
					</tr>
				@endforeach
				
				
		  </thead>
	</table>
	{{ $salesAreas->links() }}
@endsection