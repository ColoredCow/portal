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
                background-color: #f5f8fa;
                text-align: center;
                width: 100%;
            }
            .content.right {
                text-align: center;
                padding-left: 30px;
                padding-right: 30px;
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
                    padding-left: 90px;
                    text-align: left;
                }
                .content {
                    height: 100%;
                }
                .content.left {
                    width: 50%;
                }
                .content.right {
                    padding-left: 60px;
                    width: 50%;
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
                    font-size: 84px;
                    padding-left: 150px;
                }
            }
        </style>
    </head>
    <body>
        <main class="h-100">
            <div class="primary-container flex-center">
                <div class="content left flex-center">
                    <div class="title w-100">Employee Portal</div>
                </div>
                <div class="content right d-flex justify-content-center flex-column">
                    <p>Solution for organizations to manage all operations' data.<br>Built over GSuite.</p>
                    <div>
                        <a href="{{ url('auth/google') }}" class="btn btn-outline-primary d-inline">Sign in with Google</a>
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
