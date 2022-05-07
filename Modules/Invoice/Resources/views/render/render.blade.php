<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,800&display=swap" rel="stylesheet">
        <!-- Styles -->
        <style>
        html,
        body {
            color: #012840;
            font-family: 'Montserrat', sans-serif;
            font-weight: 400;
            margin: 0;
            padding: 0;
            height: 100%;
            background-size: 100% 100%;
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

        .font-bold {
            font-weight: bold
        }

        .font-montserrat-regular {
            font-family: 'Montserrat';
            font-weight: 400;
        }

        .font-montserrat-medium {
            font-family: 'Montserrat';
            font-weight: 500;
        }

        .font-montserrat-semibold {
            font-family: 'Montserrat';
            font-weight: 600;
        }

        .font-montserrat-bold {
            font-family: 'Montserrat';
            font-weight: 700;
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
    </style>
    </head>
    <body>
        <header>
            <div style="width:100%;">
                <table>
                    <tr>
                        <td align="center" class="fz-20">INVOICE</td>
                    </tr>
                    <tbody>
                        <tr valign="top">
                            <td>
                                <img src="{{public_path() . '/images/coloredcow.png'}}" alt="" height="50" width="200">
                            </td>
                            <td>
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
                                <p>Bill To</p>
                                <p>Rakhee Gupta</p>
                                <p>Confederation of Indian Industry</p>
                                <p>rakhee.gupta@cii.in</p>
                            </td>
                            <td align="right">
                                <p>Details</p>
                                <p>Invoice Number :IN033-016-000002</p>
                                <p>Issue Date :April 2, 2022</p>
                                <p>Due Date :April 12, 2022</p>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <p>Client Name: Confederation of Indian Industry</p>
                                <p>Client ID: 033</p>
                                <p>Project Name: 17th Africa Conclave</p>
                                <p>Project ID: 016</p>
                                <p>Category : Web Application Development</p>
                            </td align="right">
                            <td>Total Amount Due: ₹53,100.00</td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <th>Description</th>
                        <th>Cost</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>17th Africa Conclave website development (50% Advance)</td>
                            <td>₹45,000.00</td>
                        </tr>
                        <tr>
                           <td align="right">
                               <p>Total ₹45,000.00</p>
                               <p>GST in INR 18.00% ₹8,100.00</p>
                               <p>Current Payable ₹53,100.00</p>
                               <p>Amount Paid ₹0.00</p>
                               <p>Current Amount Due in INR ₹53,100.00</p>
                           </td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <th>Transaction Details</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p>Transaction Method :Bank Transfer</p>
                                <p>Bank Name :Citibank N.A. Delhi, India</p>
                                <p>Swift Code :CITIINBX</p>
                                <p>Bank/IFCI Code :CITI0000002</p>
                                <p>Account Number :0077793224</p>
                                <p>A/C Holder Name :ColoredCow Consulting Pvt. Ltd.</p>
                                <p>Phone :91-9818571035</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
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
        </header>
    </body>
</html>
