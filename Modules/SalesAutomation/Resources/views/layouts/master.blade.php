@extends('layouts.app')

@section('content')
    <div class="container-fluid">
    	<div class="row">
			<div class="col-md-3">
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					@foreach (config('salesautomation.tabs') as $tab)
						@php
							$active = in_array(\Route::current()->getName(), $tab['active']) ? 'active' : '';

@endphp
						<a class="nav-link {{$tab['label'] === "Client Database" ? 'disabled' : ""}} {{ $active }}" href="{{ $tab['route'] ? route($tab['route']) : '#' }}" role="tab">{{ $tab['label'] }}</a>
					@endforeach
				</div>
			</div>
			<div class="col-md-9">
            	@yield('salesautomation.content')
			</div>
		</div>
	</div>
@endsection

@section('css_scripts')
    <link href="{{ mix('/css/salesautomation.css') }}" rel="stylesheet">
@endsection

@section('js_scripts')
    <script src="{{ mix('/js/salesautomation.js') }}"></script>
@endsection

