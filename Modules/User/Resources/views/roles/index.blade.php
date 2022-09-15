@extends('user::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    @includeWhen(session('success'), 'toast', ['message' => session('success')])
	@include('user::layouts.navbar')
	<h4>Roles management </h4>
	<a type="submit" href="{{route('user.show-form')}}" class="btn btn-primary float-right mb-5">Add Data
    </a>
	<role-listing
		:roles="{{ json_encode($roles) }}"
		:permissions = "{{ json_encode($permissions)  }}"
		:update-route="{{ json_encode( route('permissions.module.index', ['module' => 'roles'])) }}"
	/>
	</div>
</div>
@endsection
