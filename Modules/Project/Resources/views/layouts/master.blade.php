@extends('layouts.app')
@section('js_scripts')
    <script src="{{ mix('js/project.js') }}"></script>
@endsection

@section('css_scripts')
	<link href="{{ mix('/css/project.css') }}" rel="stylesheet">
@endsection
