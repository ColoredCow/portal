@extends('layouts.app')

@section('content')
<div class="container">
	<ul class="nav nav-pills mb-3 px-3">
		<li class="nav-item">
			<a class="nav-item nav-link active" href="#"><i class="fa fa-users"></i>&nbsp;Users</a>
		</li>
		<li class="nav-item">
			<a class="nav-item nav-link" href="{{ route('permissions.module.index', ['module' => 'roles']) }}"><i class="fa fa-list-ul"></i>&nbsp;Roles</a>
		</li>
	</ul>
	<br>
	<div class="container"
	data-users ="{{ json_encode($users) }}"
	data-roles="{{ json_encode($roles) }}"
	data-update-route="{{ route('permissions.module.index', ['module' => 'users']) }}"
	>
		<h4>User Management</h4>
		<table class="table table-bordered table-striped">
			<thead class="thead-dark">
				<tr>
					<th width="20%">User Name</th>
					<th width="35%">User Roles</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tr v-for="(user,index) in users">
				<td>@{{ user.name }}</td>
				<td>
						@{{ formatRoles(user) }}
				</td>
				<td>
					<button class="btn btn-sm btn-outline-danger" v-if="user.roles.length == 0" data-toggle="modal" data-target="#update_user_roles_modal" @click="updateUserRolesModal(index)">No role assigned</button>
					<button class="btn btn-sm btn-outline-info" v-else data-toggle="modal" data-target="#update_user_roles_modal" @click="updateUserRolesModal(index)">View roles assigned</button>

					<button class="btn btn-sm btn-outline-danger" v-if="user.roles.length == 0" data-toggle="modal" data-target="#update_staff_type_modal" @click="updateStaffTypeModal(index)">Nomber role assigned</button>
					<button class="btn btn-sm btn-outline-info" v-else data-toggle="modal" data-target="#update_staff_type_modal" @click="updateStaffTypeModal(index)">Viewber roles assigned</button>
				</td>
			</tr>
		</table>
	</div>
</div>
@endsection
