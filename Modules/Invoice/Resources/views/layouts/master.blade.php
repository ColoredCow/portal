@extends('layouts.app')
@section('css_scripts')
	<link href="{{ mix('/css/invoice.css') }}" rel="stylesheet">
@endsection

@section('js_scripts')
<script src="{{ mix('/js/invoice.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
@endsection
