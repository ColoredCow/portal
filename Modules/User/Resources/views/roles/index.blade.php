@extends('user::layouts.master')
@section('content')

<div class="container" id="vueContainer">
	<ul class="nav nav-pills mb-3 px-3">
		<li class="nav-item">
			<a class="nav-item nav-link " href="{{ route('user.index')  }}"><i class="fa fa-users"></i>&nbsp;Users</a>
		</li>
		<li class="nav-item">
			<a class="nav-item nav-link active" href="{{ route('user.role-index') }}"><i class="fa fa-list-ul"></i>&nbsp;Roles</a>
		</li>
	</ul>
	<br>
        <h4>Roles management</h4>
        <role-listing 
        :roles="{{ json_encode($roles) }}"
        :permissions = {{ json_encode($permissions)  }}
        :update-route="{{ json_encode( route('permissions.module.index', ['module' => 'roles'])) }}"
        />
		

	</div>
</div>
@endsection
