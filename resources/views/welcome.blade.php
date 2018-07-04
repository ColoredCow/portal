<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('favicon.png') }}" sizes="32x32" />
        <link href="{{ mix('css/welcome.css') }}" rel="stylesheet">
    </head>
    <body>
        <main>
            <div class="main-wrapper h-100 flex-wrap flex-center">
                <div class="content left flex-center flex-column">
                    <div class="content-block text-white text-left">
                        <h2 class="title font-weight-bold">Never again be troubled by processes and data all over the place.</h2>
                        <h3 class="subtitle">All your organization processes and data at one central source.</h3>
                        <ul class="features px-0">
                            <li>Finance</li>
                            <li>Hiring and HR</li>
                            <li>Employee data</li>
                            <li>Team management</li>
                            <li>Project details</li>
                        </ul>
                    </div>
                </div>
                <div class="content right flex-center flex-column">
                    <div class="content-block">
                        <h2 class="subtitle font-weight-bold text-dark">For all organisations,<br>big or small</h2>
                        <p class="text-dark">An effortless way to make your organization efficient, with data driven decision making</p>
                        <a href="{{ url('auth/google') }}" class="btn btn-primary">One click sign up with Google</a>
                        <small class="d-block mt-1 mb-3 pl-2 font-weight-light">to start using the portal...</small>
                        <a href="{{ url('auth/google') }}" class="btn btn-outline-primary">Sign in with Google</a>
                    </div>
                </div>
            </div>
        </main>
        <footer style="position: relative;">
            <div class="bottom-right">
                <a href="https://coloredcow.com" target="_blank">
                    <img src="{{ asset('cc-logo.png') }}" alt="ColoredCow" class="cc-logo">
                </a>
            </div>
        </footer>
    </body>
</html>
