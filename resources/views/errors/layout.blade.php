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
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                @guest
                <a class="navbar-brand" href="{{ url('/') }}">
                    @else
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        @endguest
                        {{ config('app.name', 'Employee Portal') }}
                    </a>
                    @auth
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            @can('hr_applicants.view')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/hr/applications/job') }}">HR</a>
                            </li>
                            @endcan
                            @can('finance_reports.view')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/finance/reports?type=monthly') }}">Finance</a>
                            </li>
                            @endcan
                            @if(auth()->user()->can('weeklydoses.view') || auth()->user()->can('library_books.view'))
                            <li class="nav-item">
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        KnowledgeCafe <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                     @can('library_books.view')
                                     <a class="dropdown-item" href="{{ route('books.index') }}">Library</a>
                                     @endcan
                                     @can('weeklydoses.view')
                                     <a class="dropdown-item" href="{{ route('weeklydoses') }}">WeeklyDose</a>
                                     @endcan
                                 </div>
                             </li>
                         </li>
                         @endif
                         @can('settings.view')
                         <li class="nav-item">
                            <a class="nav-link" href="{{ url('/settings/hr') }}">Settings</a>
                        </li>
                        @endcan
                    </ul>
                </div>
                @endauth
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @auth
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{-- <img src="{{ $user->avatar }}" class="user-avatar">&nbsp; --}}
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

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
