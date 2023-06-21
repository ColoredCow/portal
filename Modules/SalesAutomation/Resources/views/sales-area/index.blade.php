@extends('salesautomation::layouts.master')

@section('salesautomation.content')
@includeWhen(session('status'), 'toast', ['message' => session('status')])
    <div class="row">
		<div class="offset-md-9 col-md-3 text-right mb-3">
			<button class="btn btn-primary" data-toggle="modal" data-target="#newSalesArea">New Sales Area</button>
		</div>
	</div>
	<table class="table table-striped table-bordered">
		<thead class="thead-dark">
		    <tr>
		      <th scope="col">Name</th>
		      <th scope="col">Actions</th>
		    </tr>
		</thead>
		<tbody>
			@forelse ($salesAreas as $index => $salesArea)
				<tr>
					<td>{{ $salesArea->name }}</td>
					<td class="w-25p">
						<form action="{{ route('sales-area.update', $salesArea) }}" method="POST">
							@csrf
							@method('PUT')
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
											<div class="form-group mt-2">
												<label for="name">Name<span class="text-danger">*</span></label>
												<input type="text" class="form-control" name="name" id="name" value="{{ old('name', $salesArea->name) }}" autofocus required>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary btn-sm">Submit</button>
										</div>
									</div>
								</div>
							</div>
						</form>
						<i data-toggle="modal" data-target="#editSalesAreaModal{{ $index }}" class="fa fa-pencil mr-2 c-pointer text-primary" ></i>
					     <span class="mr-2 text-danger c-pointer" onclick="if(confirm('Are you sure you want to delete?'))document.getElementById('deleteSalesArea-{{ $salesArea->id }}').submit();"><i class="fa fa-trash"></i></span>
						<form action="{{ route('sales-area.destroy', $salesArea) }}" method="POST" id="deleteSalesArea-{{ $salesArea->id }}">
							@csrf
							@method('DELETE')
						</form>
					</td>
				</tr>
				@empty
				<tr>
                    <td colspan="2">
						<div class="d-flex justify-content-center">
							<img src="{{ URL('images/no-result.png') }}" class='img-center' alt="" width="50%">
						</div>
						<div class="container-fluid d-flex justify-content-center">
							<span class="text-primary">NO DATA FOUND</span>
						</div>
                    <td>
	           </tr>
			@endforelse
	    </tbody>
	</table>
	{{ $salesAreas->links() }}
@endsection

<div class="modal fade" id="newSalesArea">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-title d-flex justify-content-between mx-2 mb-0 mt-2">
				<h2>New Sales Area</h2>
				<button class="btn btn-secondary" data-dismiss="modal"><span>&times</span></button>
			</div>
			<form action="{{ route('sales-area.store') }}" method="POST">
			@csrf
				<div class="modal-body mt-1">
					<div class="card my-0">
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<label for="name">Name<span class="text-danger">*</span></label>
										<input type="text mw-100" class="form-control" name="name" id="name" value="{{ old('name') }}" autofocus required>
									</div>
								</div>
							</div>	
						</div>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-end px-3 my-0 pb-2">
					<button type="submit" class="btn btn-secondary btn-lg mr-1" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary btn-lg">Submit</button>
				</div>	
			</form>
		</div>
	</div>
</div>
