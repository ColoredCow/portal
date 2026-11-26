@extends('layouts.app')

@section('css_scripts')
<link href="/lib/fullcalendar/lib/main.min.css" rel="stylesheet">
@vite(['Modules/AppointmentSlots/Resources/assets/sass/app.scss'])
@endsection

@section('js_scripts')
@vite(['Modules/AppointmentSlots/Resources/assets/js/app.js'])
<script type="text/javascript" src="/lib/fullcalendar/lib/main.min.js"></script>
@endsection
