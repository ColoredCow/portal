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
                right: 30px;
                bottom: 30px;
            }
            .title {
                font-size: 84px;
                padding-left: 150px;
            }
            .content.left {
				background-color: #f5f8fa;
            }
            .content.right {
				padding-left: 60px;
            }
            .cc-logo {
            	height: 60px;
            }
        </style>
    </head>
    <body>
    	<main class="h-100">
    		<div class="flex-center h-100">
	    		<div class="content left flex-center w-50 h-100">
					<div class="title w-100">Employee Portal</div>
	    		</div>
	    		<div class="content right d-flex justify-content-center w-50 flex-column h-100">
					<p>Solution for organizations to manage all operations' data.<br>Built over GSuite.</p>
					<div>
						<a href="{{ url('auth/google') }}" class="btn btn-outline-primary d-inline">Sign in with Google</a>
					</div>
	    		</div>
    		</div>
    	</main>
    	<footer>
    		<div class="container-fluid">
				<a href="https://coloredcow.com" target="_blank" class="bottom-right">
					<img src="{{ asset('cc-logo.png') }}" alt="ColoredCow" class="cc-logo">
				</a>
    		</div>
    	</footer>
    </body>
</html>
