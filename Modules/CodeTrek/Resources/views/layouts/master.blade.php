@extends('layouts.app')
@section('js_scripts')
@vite(['Modules/CodeTrek/Resources/assets/js/app.js'])
@endsection
@section('css_scripts')
@vite(['Modules/CodeTrek/Resources/assets/sass/app.scss'])
@endsection
<input type="hidden" id="get_report_data_url" value={{ route('reports.codetrek.get-report-data') }}>
