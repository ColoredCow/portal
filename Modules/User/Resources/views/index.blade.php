@extends('user::layouts.master')
@section('content')

<div class="container" id="vueContainer">
	<ul class="nav nav-pills mb-3 px-3 d-none">
		<li class="nav-item">
			<a class="nav-item nav-link active" href="{{ route('user.index')  }}"><i class="fa fa-users"></i>&nbsp;Users</a>
		</li>
		<li class="nav-item">
			<a class="nav-item nav-link" href="{{ route('user.role-index') }}"><i class="fa fa-list-ul"></i>&nbsp;Roles</a>
		</li>
	</ul>
	<br>
		<h4>User Management</h4>
		<user-listing 
			:users="{{ json_encode($users) }}"
			:update-route="{{ json_encode( route('permissions.module.index', ['module' => 'users'])) }}"
			:user-permissions = "{{ json_encode(
				[ 
				'can-assign-roles' => auth()->user()->can('user_management.assign-roles'),
				'can-delete' => auth()->user()->can('user_management.delete'),
				], true)}}"
			:config = "{{ json_encode(['website_url' => config('website.url')]) }}"
		/>

	</div>
</div>
@endsection
