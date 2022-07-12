@extends('')

@section('css_scripts')
<link href="/lib/fullcalendar/lib/main.min.css" rel="stylesheet">
<link href="{{ mix('/css/appointmentslots.css') }}" rel="stylesheet">
@endsection

@section('js_scripts')
<script src="{{ mix('/js/appointmentslots.js') }}" defer></script>
<script type="text/javascript" src="/lib/fullcalendar/lib/main.min.js"></script>
@endsection
