@extends('layouts.app')
@section('js_scripts')
    @vite(['Modules/Project/Resources/assets/js/app.js'])
@endsection

@section('css_scripts')
	@vite(['Modules/Project/Resources/assets/sass/app.scss'])
@endsection
