@extends('layouts.app')
@section('js_scripts')
@vite(['Modules/Invoice/Resources/assets/js/app.js'])
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
@endsection

@section('css_scripts')
@endsection