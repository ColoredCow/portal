@extends('user::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    @includeWhen(session('success'), 'toast', ['message' => session('success')])
	@include('user::layouts.navbar')
	<h4>Roles management </h4>
	<button type="button" class="btn btn-primary float-right mb-6" data-toggle="modal" data-target="#rolesModal">
	ADD NEW ROLE
	</button>
	
	<role-listing
		:roles="{{ json_encode($roles) }}"
		:permissions = "{{ json_encode($permissions)  }}"
		:update-route="{{ json_encode( route('permissions.module.index', ['module' => 'roles'])) }}"
	/>
	</div>
	<div class="modal fade" id="rolesModal" tabindex="-1" role="dialog" aria-labelledby="rolesModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="rolesModalLabel">ADD NEW ROLE</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="{{ route('user.store-roles'  ) }}" method="POST">
						@csrf
						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" class="form-control" name="name" required>
							@error('name')
										<div class="alert alert-danger">{{ $message }}</div>
									@enderror 
						</div>
						<div class=" form-group">
							<label for="label" >Label</label><strong class="text-danger">*</strong>
							<input type="text" class="form-control " name="label" required>
							@error('label')
                            <div class="alert alert-danger">{{ $message }}</div>
                                 @enderror
						</div>
						<div class=" form-group">
							<label for="guard_name" >Guard Name</label><strong class="text-danger">*</strong>
							<input type="text" class="form-control" name="guard_name" required>
							<span class="text-danger">
								@error('guard_name')
								  {{$message}}
								@enderror
							</span>
						</div>
						<div class="form-group">
							<label for="description">Description</label><strong class="text-danger">*</strong>
							<input type="text" class="form-control" name="description" required>
							<span class="text-danger">
								@error('description')
								  {{$message}}
								@enderror
							</span>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-sm btn-outline-danger">Save</button>
						</div>
					</form> 
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
