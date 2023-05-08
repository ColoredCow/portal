<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="32x32" />

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('css_scripts')

    <!-- Reports -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>

    <!-- JQuery -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container-fluid">
                <a class="navbar-brand min-w-md-150" href="{{ url('/') }}">
                    {{ config('app.name', 'ColoredCow Portal') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @auth
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        @include('layouts.navbar')
                    </div>
                @endauth
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @auth
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center"
                                    href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false" v-pre>
                                    <img src="{{ auth()->user()->avatar }}"
                                        class="user-avatar w-25 h-25 rounded-circle mr-1">
                                    <span>
                                        <span class="caret"></span>
                                    </span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @if (Module::checkStatus('User'))
                                        @php
                                            $employee = DB::table('employees')
                                                ->where('user_id', auth()->user()->id)
                                                ->first();
                                        @endphp
                                        <a class="dropdown-item" href="{{ route('employees.show', $employee->id) }}">My
                                            profile</a>
                                    @endif
                                    @if (auth()->user()->provider == 'google')
                                        <a class="dropdown-item" href="{{ route('profile.gsuite-sync') }}">Sync my
                                            profile</a>
                                    @endif
                                    @if (auth()->user()->isSuperAdmin())
                                        <a class="dropdown-item" href="{{ route('profile.gsuite-sync-all') }}">Sync all
                                            users</a>
                                    @endif
                                    @if (auth()->user()->canAccessWebsite())
                                        <a target="_blank" class="dropdown-item"
                                            href="{{ config('constants.website_url') . '/wp/wp-admin/' }}">Go to
                                            website</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('user.settings') }}">User Settings</a>
                                    <a class="dropdown-item" id="logout" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endauth
                        <button id="applicant-toggle" style="border: none; background-color: transparent;"><i
                                class="fa fa-bars" style="border: none;"></i></button>
                        <div id="applicant-sidebar">
                            <h5 style="font-weight: bold;">CodeTrek Applicants</h5>
                            <ul class="applicant-list">
                                @include('codetrek::sidebar')
                            </ul>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(function() {
                                // When the hamburger icon is clicked, toggle the sidebar
                                $('#applicant-toggle').click(function() {
                                    $('#applicant-sidebar').css('right', '0');
                                });

                                // When an applicant is clicked, load their details
                                $('.applicant-list li').click(function() {
                                    var applicantId = $(this).data('id');
                                    $.ajax({
                                        url: '/code-trek-applicants/' + applicantId,
                                        success: function(data) {
                                            // Display applicant details in the main content area
                                            $('#main-content').html(data);
                                        }
                                    });
                                });

                                // When the user clicks outside the sidebar, hide it
                                $(document).click(function(event) {
                                    if (!$(event.target).closest('#applicant-toggle, #applicant-sidebar').length) {
                                        $('#applicant-sidebar').css('right', '-200px');
                                    }
                                });

                                // Styles for the sidebar
                                $('#applicant-sidebar').css({
                                    position: 'fixed',
                                    top: '60px',
                                    right: '-200px',
                                    width: '200px',
                                    padding: '10px',
                                    border: '1px solid #ccc',
                                    backgroundColor: '#f9f9f9',
                                    transition: 'right 0.3s ease-in-out'
                                });

                                $('.applicant-list').css({
                                    listStyle: 'none',
                                    padding: '0',
                                    margin: '0'
                                });

                                $('.applicant-list li').css({
                                    cursor: 'pointer',
                                    padding: '5px'
                                });

                                $('.applicant-list li:hover').css({
                                    backgroundColor: '#e6e6e6'
                                });
                            });
                        </script>
                    </ul>
                </div>
            </div>
        </nav>

        @if (session('status'))
            <div class="w-full flex-center">
                <div class="alert alert-success alert-dismissible fade show position-absolute z-index-1100 fz-14 shadow mb-5 ml-5 top-8.33"
                    role="alert" id="statusAlert">
                    <span>{!! session('status') !!}</span>
                    <button type="button" class="close pt-1.5" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        <main class="py-4 mx-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <script src="{{ asset('src/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>

    @yield('js_scripts')
    @yield('vue_scripts')

    <script>
        @yield('inline_js')
    </script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>

</html>
