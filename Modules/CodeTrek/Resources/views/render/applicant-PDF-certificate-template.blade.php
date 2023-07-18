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
            font-family: sans-serif;
            line-height: 1.15;
            -webkit-text-size-adjust: 100%;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            margin: 0;
            padding: 0;
            height: 100%;
            background-size: 100% 100%;
            font-size: 12px;
            background: white !important;
        }

        .w-100p {
            width: 100%;
        }
    </style>
</head>

<body>

    <div class="w-100p">
        <h2 style="text-align: center; font-weight: bold;">Certificate</h2>
        <img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" height="50" width="200">
    </div>

</body>

</html>
