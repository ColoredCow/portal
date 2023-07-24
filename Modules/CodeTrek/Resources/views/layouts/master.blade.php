@extends('layouts.app')
@section('js_scripts')
<script src="{{ mix('js/codetrek.js') }}"></script>
@endsection
@section('css_scripts')
<link href="{{ mix('css/codetrek.css') }}" rel="stylesheet">
@endsection
<input type="hidden" id="get_report_data_url" value={{ route('reports.codetrek.get-report-data') }}>
