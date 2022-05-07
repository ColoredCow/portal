@extends('user::layouts.master')
@section('content')

<div class="container" id="vueContainer">
	@include('user::layouts.menu')
	<br>
        <h4>Roles management</h4>
        <role-listing
        :roles="{{ json_encode($roles) }}"
        :permissions = "{{ json_encode($permissions)  }}"
        :update-route="{{ json_encode( route('permissions.module.index', ['module' => 'roles'])) }}"
        />


	</div>
</div>
@endsection
