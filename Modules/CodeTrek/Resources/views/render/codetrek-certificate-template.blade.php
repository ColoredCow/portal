<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Styles -->
    <style>
        html,
        body {
            font-weight: normal;
            font-family: 'Abril Fatface', cursive;
            margin: 0;
            padding: 0;
        }

        .background {
            background-image: url('/images/codetrek-certificate-outline.png');
            background-size: contain;
            background-repeat: no-repeat;
            position: absolute;
            margin: 10px;
            top: 0;
            left: 0;
            width: 98%;
            height: 100%;
            opacity: 0.3;
            z-index: -1;
        }

        .logo {
            text-align: center;
            height: 36px;
            width: 168.8px;
            margin-top: 82.5px;
        }

        .logo1 {
            text-align: center;
        }

        .heading {
            text-align: center;
        }

        .heading1 {
            font-size: 30px;
            margin-top: 27.5px;
            color: #B21F56;
        }
    </style>
</head>

<body>
    <div class="background"></div>

    <div class="logo1">
        <img class="logo" src="{{ public_path() . '/images/coloredcow.png' }}" alt="">
    </div>

    <div class="heading">
        <p class="heading1">Internship Certificate <br> of Completion</p>
    </div>

</body>

</html>
