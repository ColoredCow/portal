@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ColoredCow Portal</title>

       {{-- Laravel Mix - CSS File --}}
       {{-- <link rel="stylesheet" href="{{ mix('css/revenue.css') }}"> --}}

    </head>
    <body>
        {{-- @yield('content') --}}

        {{-- Laravel Mix - JS File --}}
        {{-- <script src="{{ mix('js/revenue.js') }}"></script> --}}
    </body>
</html>
@section('js_scripts')
<script src="{{ mix('/js/revenue.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
@endsection
