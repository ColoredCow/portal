@extends('salesautomation::layouts.master')

@section('salesautomation.content')
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
			@foreach ($salesAreas as $index => $salesArea)
                
				<tr>
					<td>{{ $salesArea->name }}</td>
					<td class="w-25p">
						<i data-toggle="modal" data-target="#editSalesAreaModal{{ $index }}" class="fa fa-pencil mr-2 c-pointer text-primary" ></i>
					
						 <div class="modal fade" id="editSalesAreaModal{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="editSalesAreaModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="editSalesAreaModalLabel">Edit Sales Area</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="col-md-12">
								 <div class="form-group">
									<form action="{{ route('sales-area.update', $salesArea) }}" method="POST">
		                                @csrf
		                                @method('PUT')
										<label for="name">Name<span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="name" id="name" value="{{ old('name', $salesArea->name) }}" autofocus required>
								     <div class="modal-footer">
									    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									    <button type="submit" class="btn btn-primary">Submit</button>
                                      </div>
</form>
								
								</div>
								</div>
                                </div>
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