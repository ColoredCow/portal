@extends('user::layouts.master')
@section('content')

<div class="container" id="vueContainer">
	@include('user::layouts.navbar')
	<h4>User Management</h4>
	<user-listing
		:users="{{ json_encode($users) }}"
		:update-route="{{ json_encode( route('user.update-roles')) }}"
		:user-permissions = "{{ json_encode(
			[
			'can-assign-roles' => auth()->user()->can('user_management.assign-roles'),
			'can-delete' => auth()->user()->can('user_management.delete'),
			], true)}}"
		:config = "{{ json_encode(['website_url' => config('website.url')]) }}"
	/>
</div>
@endsection
