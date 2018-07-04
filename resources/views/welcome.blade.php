<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('favicon.png') }}" sizes="32x32" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
                font-size: 18px;
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
            .bottom-right {
                position: absolute;
                bottom: 15px;
                display: block;
                width: 100%;
                text-align: center;
            }
            .title {
                font-size: 60px;
            }
            .content.left {
                background-size: cover;
                background-repeat: no-repeat;
                text-align: center;
                width: 100%;
            }
            .content.right {
                text-align: center;
                padding-bottom: 30px;
            }
            .cc-logo {
                height: 45px;
            }
            .primary-container {
                flex-wrap: wrap;
            }

            .primary-container {
                height: 100%;
            }
            .content {
                height: 50%;
            }

            @media only screen and (min-width: 992px) {
                .title {
                    font-size: 72px;
                    text-align: left;
                }
                .content {
                    height: 100%;
                }
                .content.left {
                    width: 60%;
                }
                .content.right {
                    width: 40%;
                    text-align: left;
                    padding-bottom: 0;
                }
                .cc-logo {
                    height: 60px;
                }
                .bottom-right {
                    right: 30px;
                    bottom: 30px;
                    text-align: right;
                }
            }
            @media only screen and (min-width: 1400px) {
                .title {
                    font-size: 36px;
                    line-height: 42px;
                }

                .content.left .content-block {
                    max-width: 450px;
                }
                .content.right .content-block {
                    max-width: 300px;
                }
                .subtitle {
                    font-size: 25px;
                    line-height: 29px;
                }
                .features {
                    list-style: none;
                    font-size: 25px;
                    line-height: 29px;
                }
            }
        </style>
    </head>
    <body>
        <main class="h-100">
            <div class="primary-container flex-center">
                <div class="content left flex-center flex-column" style="background-image: url('{{ asset('images/background-min.png') }}');">
                    <div class="content-block text-white text-left">
                        <h2 class="title w-100">Never again be troubled by processes and data all over the place.</h2>
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
                        <a href="#" class="btn btn-outline-primary">Sign in with Google</a>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <a href="https://coloredcow.com" target="_blank" class="bottom-right">
                <img src="{{ asset('cc-logo.png') }}" alt="ColoredCow" class="cc-logo">
            </a>
        </footer>
    </body>
</html>
