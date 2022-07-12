<<<<<<< Updated upstream
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module Lead</title>

       {{-- Laravel Mix - CSS File --}}
       {{-- <link rel="stylesheet" href="{{ mix('css/lead.css') }}"> --}}

    </head>
    <body>
        @yield('content')

        {{-- Laravel Mix - JS File --}}
        {{-- <script src="{{ mix('js/lead.js') }}"></script> --}}
    </body>
</html>
=======
@extends('layouts.app')
@section('js_scripts')
{{-- <script src="{{ mix('/js/user.js') }}" defer></script> --}}
@endsection

@section('css_scripts')
{{-- <link href="{{ mix('/css/user.css') }}" rel="stylesheet"> --}}
@endsection

>>>>>>> Stashed changes
