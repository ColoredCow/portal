<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">


    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
    html, body {
        font-color: #636b6f;
        font-family: 'Raleway', sans-serif;

        height: 100vh;
        margin: 0;
    }
    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 36px;
        padding: 20px;
        font-weight: 100;
    }
</style>
</head>
<body>
    <div id="app">
        @include('layouts.nav')

        <main class="py-4">
            <div class="flex-center position-ref full-height">
                <div class="content">
                    <div class="title">
                        @yield('message')
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script src="{{ asset('src/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
