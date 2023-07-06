@extends('layouts.app')
@section('js_scripts')
<script src="{{ mix('js/codetrek.js') }}"></script>
@endsection
@section('css_scripts')
@endsection
<input type="hidden" id="get_report_data_url" value={{ route('codetrek.get-report-data') }}>
