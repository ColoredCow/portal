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
				@foreach ($salesAreas as $salesArea)
					<tr>
						<td>{{ $salesArea->name }}</td>
						<td class="w-25p">
							<a href="{{ route('sales-area.edit', $salesArea) }}" class="mr-2"><i class="fa fa-pencil"></i></a>
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