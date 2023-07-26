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
            /* height: 80px;
            width: 310px; */
            text-align: center;
        }
        
        .heading1 {
            font-size: 30px;
            margin-top: 27.5px;
            color: #B21F56;
        }

        
        .candidate-name {
            text-align: center;
            font-size: 30px;
            margin-top: 50px;
        }

        .content {
            font-family: 'Roborto', sans-serif;
            text-align: center;
            font-size: 14px;
            margin-top: 50px;
        }

        .conductor-name {
            font-family: 'Poppins', sans-serif;
            margin-left: 100px;
            margin-top: 220px;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="background">

        <div class="logo1">
            <img class="logo" src="{{ public_path() . '/images/coloredcow.png' }}" alt="">
        </div>

        <div class="heading">
            <p class="heading1">Internship Certificate <br> of Completion</p>
        </div>

        <div class="candidate-name">
            Candidate <br>name
        </div>


        <div class="content">
            <p>
                Coloredcow is glad to certify that |**Candidate Name**| successfully<br>
                completed his internship from |**Start Date**| to |**End Date**|.<br><br>
                He/She gained exposure to working with teams in an organizatioal<br>
                environment, worked on the fundamentals of software development<br>
                using the right tools and best practices, and polished his skills in learning<br>
                and building Open Source Applicantions. <br><br>
                ColoredCow recognizes his desire to learn and wishes him great <br> success!
            </p>
        </div>


        <div class="conductor-name">
            <p>
                |**Conductor Name**|<br>
                |**Degisnation**|<br>
                |**Company Name**|
            </p>
        </div>
    </div>
</body>

</html>
