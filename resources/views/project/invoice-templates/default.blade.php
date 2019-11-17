<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->

    <!-- Styles -->
    @if($isPdf) 
        <link href="{{ public_path('css/app.css') }}" rel="stylesheet">
    @else
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @endif

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="py-4" style="background-color: #fff">
            <div class="text-center" style="font-size:30px;">
                <p>INVOICE</p>
            </div>

            <div class="row mb-4">
                <div class="col-6">
                    <div class="w-75">
                            @if($isPdf) 
                            <img class="image-responsive w-100" src="{{ public_path('images/coloredcow-logo.png') }}" alt="">
                            @else
                            <img class="image-responsive w-100" src="{{ 'images/coloredcow-logo.png'}}" alt="">
                            @endif
                    </div>
                   
                </div>
                <div class="col-6 text-right">
                    <p class="text-muted">
                        <span> F-61, Suncity, Sector - 54 </span><br>  
                        <span> Gurgaon, Haryana, 122003, India </span> <br>  
                        <span> finance@coloredcow.com </span> <br>
                        <span> 91 9818571035 </span> <br>
                    </p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-6">
                    <span class="font-weight-bold" style="font-size:15px;">Bill To</span>
                    <p>
                        <span>Debbie Vereb</span><br>
                        <span>illuma Care Connections</span><br>
                        <span>dvereb@illumacc.com</span><br>
                        <span>11475 Great Oaks Way,</span><br>
                        <span>Suite 320, Alpharetta GA 30022</span><br>
                        <span>(770) 847-7367</span>
                    </p>
                </div>
                <div class="col-6">
                    <span class="font-weight-bold" style="font-size:15px;">Details</span>
                    <div class="row">
                        <div class="col-6">Term:</div>
                        <div class="col-6">October (1 - 15)</div>
                    </div>

                    <div class="row">
                        <div class="col-6">Invoice Number :</div>
                        <div class="col-6">012-001-000044</div>
                    </div>

                    <div class="row">
                        <div class="col-6">Issue Date :</div>
                        <div class="col-6">October 16, 2019</div>
                    </div>

                    <div class="row">
                        <div class="col-6">Due Date :</div>
                        <div class="col-6">October 26, 2019</div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-6">
                    <span class="font-weight-bold" style="font-size:15px;">illuma(001) Total Amount Due</span><br>
                    <span class="font-weight-bold" style="font-size:15px;">Account ID : illuma Care Connections(012)</span><br>
                    <span class="font-weight-bold" style="font-size:15px;">Category : Web app development</span>        
                </div>
                <div class="col-6 text-right">
                    <div class="row">
                        <div class="col-6">Total Amount Due</div>
                        <div class="col-6">
                            <span class="font-weight-bold" style="font-size:15px;">$440.00</span>
                        </div>
                    </div>
                </div>
            </div>


            <div class=row>
                <div class="col-4">Description</div>
                <div class="col-4">Hours</div>
                <div class="col-2">Rate (US $)</div>
                <div class="col-2">Cost (US $)</div>
            </div>

            <div class=row>
                <div class="col-4">All Member Export Updates</div>
                <div class="col-4">3.25</div>
                <div class="col-2">35</div>
                <div class="col-2">113.75</div>
            </div>

            <div class=row>
                <div class="col-4">Static Code Analysis</div>
                <div class="col-4">8</div>
                <div class="col-2">35</div>
                <div class="col-2">280</div>
            </div>


            <div class=row>
                <div class="offset-4 col-7">
                    Total <br>
                    Discount ( $5 Per hours )<br>
                    Total After Discount<br>
                    Amount Paid<br>
                    Amount Due in US $
                </div>
            </div>


            <div class="row">
                <div class="col-6">
                    Transaction Details <br>
                    Transaction Method : Wire Transfer <br>
                    Bank Name : Citibank N.A. Delhi, India<br>
                    Swift Code: CITIINBX<br>
                </div>
            </div>

            <div>
                <a href="https://google.com">For more details of this invoice you can visit this sheet.</a>
                <br>
                Thank you for your business. It’s a pleasure to work with you on your project.
            </div>

            <div>
                    Sincerely,<br>
                    Prateek Narang <br>
                    prateek.narang@coloredcow.com <br>
                    ColoredCow <br>
            </div>

        </div>
    </div>

    <!-- Scripts -->

    @if($isPdf) 
        <script src="{{ public_path('js/app.js') }}"></script>
    @else
        <script src="{{ mix('js/app.js') }}"></script>
    @endif

   
</body>
</html>
