<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Source Sans Pro:400,500,600,700,800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <!-- Styles -->
        <style>
        html,
        body {
            color: #012840;
            font-family: 'Source Sans Pro', 'sans-serif';
            font-weight: normal;
            margin: 0;
            padding: 0;
            height: 100%;
            background-size: 100% 100%;
            font-size: 12px;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 44px !important;
            color: #2E3091;
        }

        .flex-row {
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            flex-direction: row;
        }

        .flex-column {
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            flex-direction: column;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .fz-20 {
            font-size: 20px;
        }

        .fz-24 {
            font-size: 24px;
        }

        .fz-16 {
            font-size: 16px;
        }

        .fz-60 {
            font-size: 60px;
        }

        .ml-auto {
            margin-left: auto;
        }

        .mr-auto {
            margin-right: auto;
        }

        .mr-100 {
            margin-right: 100px;
        }

        .ml-100 {
            margin-left: 100px;
        }

        .mt-40 {
            margin-top: 40px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mr-80 {
            margin-right: 80px;
        }

        .pt-20 {
            padding-top: 20px;
        }

        .h-200 {
            height: 200px;
        }

        .w-500 {
            width: 500px;
        }

        .w-850 {
            width: 850px;
        }

        .pt-100 {
            padding-top: 100px;
        }

        .ml-150 {
            margin-left: 150px;
        }

        .bg-title-blue {
            background-color: #40A3E4;
        }

        .bg-theme-blue {
            background-color: #014B7B;
        }

        .text-white {
            color: white;
        }

        .px-10 {
            padding-left: 10px;
            padding-right: 10px;
        }

        .px-30 {
            padding-left: 30px;
            padding-right: 30px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-0 {
            margin-bottom: 0px !important;
        }

        .page-break-before {
            page-break-before: always;
        }
        .ml-200 {
            margin-left: 200px;
        }
        .px-10 {
            padding-left: 10px;
            padding-right: 10px;
        }
        table {
            width: 100%;
        }
        .w-full {
            width: 100%;
        }
        .w-30p {
            width: 30%;
        }
        .w-70p {
            width: 70%;
        }
        .mt-80 {
            margin-top: 80px;
        }
        .w-13p {
            width: 12.5%;
        }
        .text-center {
            text-align: center;
        }
        .w-25p {
            width: 25%;
        }
        .w-33 {
            width: 33%;
        }
        td p {
            margin: 0px !important;
        }
        table {
            border-collapse: separate;
            border-spacing: 0 1em;
        }
        .fw-bold {
            font-weight: bold !important;
        }
        tr, td{
            padding: 0 !important;
            margin: 0 !important;
        }
    </style>
    </head>
    <body>
        <header>
            <div style="width:100%;">
                <h2 style="text-align: center; font-weight: bold;">INVOICE</h2>
                <table>
                    <tbody>
                        <tr valign="top">
                            <td>
                                <img src="{{public_path() . '/images/coloredcow.png'}}" alt="" height="50" width="200">
                            </td>
                            <td style="color: grey;" align="right">
                                <p>F-61, Suncity, Sector - 54</p>
                                <p>Gurgaon, Haryana, 122003, India</p>
                                <p>finance@coloredcow.com</p>
                                <p>91 9818571035</p>
                                <p>PAN : AAICC2546G</p>
                                <p>GSTIN : 06AAICC2546G1ZT</p>
                                <p>SAC / HSN code : 998311</p>
                                <p>CIN No. U72900HR2019PTC081234</p>
                            </td>
                        </tr>
                        <tr style="width:100%;">
                            <td align="left">
                                <p class="fw-bold">Bill To</p>
                                <p>{{$keyAccountManager->name}}</p>
                                <p>Confederation of Indian Industry</p>
                                <p>rakhee.gupta@cii.in</p>
                                <p>The Mantosh Sondhi Centre</p>
                                <p>Institutional Area, Lodi Road, Delhi -110003</p>
                                <p>GSTIN : 07AAATC0188R1ZB</p>
                            </td>
                            <td>
                                <p class="fw-bold">Details</p>
                                <table>
                                    <tr>
                                        <td>
                                            <p>Invoice Number :</p>
                                            <p>Issue Date :</p>
                                            <p>Due Date :</p>
                                        </td>
                                        <td align="right">
                                            <p>IN033-016-000002</p>
                                            <p>April 2, 2022</p>
                                            <p>April 12, 2022</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td align="left" class="fw-bold">
                                <p>Client Name: Confederation of Indian Industry</p>
                                <p>Client ID: 033</p>
                                <p>Project Name: 17th Africa Conclave</p>
                                <p>Project ID: 016</p>
                                <p>Category : Web Application Development</p>
                            </td>
                            <td align="right">
                                <table>
                                    <tr>
                                        <td>
                                            <p>Total Amount Due :</p>
                                        </td>
                                        <td align="right">
                                            <p><strong>₹53,100.00</strong></p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Description</th>
                            <th scope="col">Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>17th Africa Conclave website development (50% Advance)</td>
                            <td>₹45,000.00</td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    <table class="table" style="margin-left: auto;width:50%;">
                        <tr>
                            <td>Total</td>
                            <td></td>
                            <td>₹45,000.00</td>
                        </tr>
                        <tr>
                            <td>GST in INR</td>
                            <td>18.00%</td>
                            <td>₹8,100.00</td>
                        </tr>
                        <tr>
                            <td>Current Payable</td>
                            <td></td>
                            <td>₹53,100.00</td>
                        </tr>
                        <tr>
                            <td>Amount Paid</td>
                            <td></td>
                            <td>₹0.00</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Current Amount Due in INR</strong>
                            </td>
                            <td></td>
                            <td><strong>₹53,100.00</strong></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table class="table table-borderless" style="width: 50%; margin-right: auto;">
                        <thead>
                            <tr>
                                <th scope="col">Transaction Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 40%;">Transaction Method:</td>
                                <td>Bank Transfer</td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">Bank Name:</td>
                                <td>Citibank N.A. Delhi, India</td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">Swift Code:</td>
                                <td>CITIINBX</td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">Bank/IFCI Code:</td>
                                <td>CITI0000002</td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">Account Number:</td>
                                <td>0077793224</td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">A/C Holder Name:</td>
                                <td>ColoredCow Consulting Pvt. Ltd.</td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">Phone:</td>
                                <td>91-9818571035</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Thank you for your business. It’s a pleasure to work with you on your project.
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Sincerely,</p>
                                    <p>ColoredCow Consulting Pvt. Ltd.</p>
                                    <p>F-61, Suncity, Sector - 54 </p>
                                    <p>Gurgaon, Haryana, 122003, India</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </header>
    </body>
</html>
