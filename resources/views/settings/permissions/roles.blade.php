@extends('layouts.app')

@section('content')
<div class="container">
	<ul class="nav nav-pills mb-3 px-3">
		<li class="nav-item">
			<a class="nav-item nav-link" href="{{ route('permissions.module.index', ['module' => 'users']) }}"><i class="fa fa-users"></i>&nbsp;Users</a>
		</li>
		<li class="nav-item">
			<a class="nav-item nav-link active" href="#"><i class="fa fa-list-ul"></i>&nbsp;Roles</a>
		</li>
	</ul>
	<br>
	<div class="container"
	id="roles_permission_table"
	data-roles="{{ json_encode($roles) }}"
	data-permissions="{{ json_encode($permissions) }}"
	data-update-route="{{ route('permissions.module.index', ['module' => 'roles']) }}"
	>
		<h4>Manage Permissions for Roles</h4>
		<table class="table table-bordered">
			<thead class="thead-light">
				<tr>
					<th>Role ID</th>
					<th>Role</th>
					<th>Permissions</th>
				</tr>
			</thead>
			<tr v-for="(role, index) in roles">
				<td>@{{ role.id }}</td>
				<td>@{{ role.name }}</td>
				<td>
					<button v-if="role.permissions.length === 0" class="btn btn-sm btn-outline-danger" @click="updatePermissionModal(index)" data-toggle="modal" data-target="#update_role_permissions_modal">No Permission Granted</button>
					<button v-else class="btn btn-sm btn-outline-primary" @click="updatePermissionModal(index)" data-toggle="modal" data-target="#update_role_permissions_modal">View permissions</button>
					@include('settings.permissions.update-role-permissions-modal')
				</td>
			</tr>
		</table>
	</div>
</div>
@endsection
