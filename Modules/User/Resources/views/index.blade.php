@extends('user::layouts.master')
@section('content')

<div class="container" >
	<ul class="nav nav-pills mb-3 px-3">
		<li class="nav-item">
			<a class="nav-item nav-link active" href="#"><i class="fa fa-users"></i>&nbsp;Users</a>
		</li>
		<li class="nav-item">
			<a class="nav-item nav-link" href="{{ route('permissions.module.index', ['module' => 'roles']) }}"><i class="fa fa-list-ul"></i>&nbsp;Roles</a>
		</li>
	</ul>
	<br>
		<h4>User Management</h4>
		<user-listing 
			:roles="{{ json_encode($roles)  }}" 
			:users="{{ json_encode($users) }}"
			:update-route="{{ json_encode( route('permissions.module.index', ['module' => 'users'])) }}"
		/>

	</div>
</div>
@endsection
