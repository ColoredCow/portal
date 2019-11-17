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

</head>

<body>
    <div id="app">
        <div class="py-4" style="background-color: #fff; color:#000">
            <div class="text-center" style="font-size:30px;">
                <p>INVOICE</p>
            </div>

            <div class="row mb-4">
                <div class="col-6">
                    <div class="w-75">
                        @if($isPdf)
                        <img class="image-responsive w-100" src="{{ public_path('images/coloredcow-logo.png') }}"
                            alt="">
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
                    <span class="font-weight-bold" style="font-size:15px;">Account ID : illuma Care
                        Connections(012)</span><br>
                    <span class="font-weight-bold" style="font-size:15px;">Category : Web app development</span>
                </div>
                <div class="col-6 text-right">
                    <div class="row">
                        <div class="col-6">Total Amount Due</div>
                        <div class="col-6">
                            <span class="font-weight-bold" style="font-size:20px;">$440.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <div class="row ">
                    <div class="col-4 pr-0">
                        <div style="background-color: #000; margin-right: 1px;">
                            <span class="text-white font-weight-bold pl-1">Description</span>
                        </div>
                    </div>
                    <div class="col-4 px-0 text-center">
                        <div style="background-color: #000">
                            <span class="text-white font-weight-bold pl-1">Hours</span>
                        </div>
                    </div>
                    <div class="col-2 px-0">
                        <div style="background-color: #000; margin-right: 1px;">
                            <span class="text-white font-weight-bold pl-1">Rate <span style="font-size:12px;">(US $)</span></span>
                        </div>
                    </div>
                    <div class="col-2 px-0">
                        <div style="background-color: #000">
                            <span class="text-white font-weight-bold pl-1">Cost <span style="font-size:12px;">(US $)</span></span>
                        </div>
                    </div>
                </div>

                <div class=row>
                    <div class="col-4">All Member Export Updates</div>
                    <div class="col-4 text-center">3.25</div>
                    <div class="col-2">35</div>
                    <div class="col-2">113.75</div>
                </div>
                <hr class="my-1">

                <div class=row>
                    <div class="col-4">Static Code Analysis</div>
                    <div class="col-4 text-center">8</div>
                    <div class="col-2">35</div>
                    <div class="col-2">280</div>
                </div>
                <hr class="my-1">

                <div class=row>
                    <div class="col-4">Moving Proivders</div>
                    <div class="col-4 text-center">1</div>
                    <div class="col-2">35</div>
                    <div class="col-2">35</div>
                </div>
                <hr class="my-1">

                <div class=row>
                    <div class="col-4">DB Cleanup</div>
                    <div class="col-4 text-center">0.5</div>
                    <div class="col-2">35</div>
                    <div class="col-2">17.5</div>
                </div>
                <hr class="my-1">

                <div class=row>
                    <div class="col-4">Network Activiation</div>
                    <div class="col-4 text-center">0.25</div>
                    <div class="col-2">35</div>
                    <div class="col-2">8.75</div>
                </div>
                <hr class="my-1">

                <div class=row>
                        <div class="col-4">Bank Transaction Charges</div>
                        <div class="col-4 text-center"></div>
                        <div class="col-2"></div>
                        <div class="col-2">50</div>
                </div>
                <hr class="my-1">
            </div>


            <div class="row mb-5">
                <div class="offset-4 col-8">
                    <div class="row">
                        <div class="col-10"> Total</div>
                        <div class="col-1">$505.00</div>
                    </div>
                    <hr class="my-1">

                    <div class="row">
                        <div class="col-10"> Discount ( $5 Per hours )</div>
                        <div class="col-1">$65.00</div>
                    </div>
                    <hr class="my-1 border-dark">

                    <div class="row">
                        <div class="col-10">Total After Discount</div>
                        <div class="col-1">$440.00</div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-10">Amount Paid</div>
                        <div class="col-1">$0.00</div>
                    </div>
                    <hr class="my-1 border-dark">
                    <div class="row">
                        <div class="col-10"> <span class="font-weight-bold text-dark">Amount Due in US $</span> </div>
                        <div class="col-1">$440.00</div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-6">

                    <span class="font-weight-bold" style="font-size:15px;">Transaction Details</span>
                    <div class="row">
                        <div class="col-6">Transaction Method:</div>
                        <div class="col-6">Wire Transfer</div>
                    </div>

                    <div class="row">
                        <div class="col-6">Bank Name :</div>
                        <div class="col-6">Citibank N.A. Delhi, India</div>
                    </div>

                    <div class="row">
                        <div class="col-6">Swift Code:</div>
                        <div class="col-6">CITIINBX</div>
                    </div>

                    <div class="row">
                        <div class="col-6">Bank/IFCI Code :</div>
                        <div class="col-6">CITI0000002</div>
                    </div>

                    <div class="row">
                        <div class="col-6">Account Number :</div>
                        <div class="col-6">0047570228</div>
                    </div>

                    <div class="row">
                        <div class="col-6">A/C Holder Name :</div>
                        <div class="col-6">ColoredCow Consulting</div>
                    </div>

                    <div class="row">
                        <div class="col-6">Phone :</div>
                        <div class="col-6">91-9818571035</div>
                    </div>
                </div>
            </div>

            <div class="position-relative">

                <div class="mb-4">
                    <a href="https://docs.google.com/spreadsheets/d/1PGupUwooZcmj75l64LrtOTB3gmFarjQ2IPB3F0f6Eqw/edit#gid=1956576418">For more details of this invoice you can visit this sheet.</a>
                    <br>
                    Thank you for your business. It’s a pleasure to work with you on your project.
                </div>

                <div>
                    Sincerely,<br>
                    Prateek Narang <br>
                    prateek.narang@coloredcow.com <br>
                    ColoredCow <br>
                </div>

                <div style="width: 100px;top: 40px;left: 149px;" class="position-absolute">
                    @if($isPdf)
                    <img class="image-responsive w-100" src="{{ public_path('images/coloredcow-stamp.png') }}"
                        alt="">
                    @else
                    <img class="image-responsive w-100" src="{{ 'images/coloredcow-stamp.png'}}" alt="">
                    @endif
                </div>

            </div>

            <div class="row mt-5">
                <div class="col-12 text-center text-muted">
                    <p>This is a system generated invoice and need not to be signed.</p>
                </div>
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