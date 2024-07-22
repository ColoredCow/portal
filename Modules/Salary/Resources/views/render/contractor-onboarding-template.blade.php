<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <style>
        @page {
            size: landscape;
            margin: 80px 20px 100px 20px;
        }
        body {
            font-weight: normal;
            font-family: sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            font-size: 14px;
            background: white !important;
        }

        .body-container {
            padding-left: 20px;
            padding-right: 20px;
        }

        .confidential-text {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            padding-top: 20px;
            text-align: center;
            text-decoration: underline;
        }

        .date {
            display: flex;
            font-size: 14px;
            padding-top: 25px;
            justify-content: flex-end;
        }

        .user-details {
            font-size: 14px;
            padding-top: 20px;
        }

        .name {
            font-weight: bold;
        }

        .address {
            font-weight: bold;
        }

        .address span {
            font-size: 14px !important
        }

        .pay-details {
            font-size: 14px;
            line-height: 20px;
        }

        table {
            border-collapse: collapse;
        }

        td {
            border: 2px solid black;
            padding: 15px;
        }

        .revised-details {
            padding-top: 20px;
            font-size: 14px;
        }

        .salary-details {
            font-size: 14px;
            padding-top: 18px;
            display: flex;
            justify-content: space-between;
        }

        .paddingTop {
            padding-top: 20px;
        }

        .content-font-size {
            font-size: 14px;
            line-height: 20px;
        }

        .salary-text {
            margin-left: 160px;
        }

        .salary-number {
            align-self: center;
        }

        .salary-number-1 {
            margin-left: 178px;
        }

        .salary-number-2 {
            margin-left: 154.5px;
        }

        .salary-number-3 {
            margin-left: 110px;
        }

        .salary-number-4 {
            margin-left: 153px;
        }

        .salary-number-5 {
            margin-left: 37px;
        }

        .salary-number-6 {
            margin-left: 68px;
        }

        .table-content {
            text-align: center;
        }

        .signature {
            font-weight: bold;
            font-size: 14px;
        }

        .signature-text {
            display: flex;
            justify-content: space-between;
        }

        .page {
            page-break-before: always;
        }
    </style>
</head>


<body>
    <div class="body-container">
        <div class="page">
            <div class="page-body">
                <div class="confidential-text">Confidential</div>
                <br>
                <div class="signature-text">
                    <span><b>To,</b></span>
                    <span style="display: block; float: right;"> Date: <b>{{$data['commencementDate']}}</b> </span>
                </div>
                <br>
                <div class="user-details">
                    <div style="margin-bottom: 5px"><b>User's Name,</b></div>
                    <div style="margin-bottom: 5px"><b>User's Address,</b></div>
                </div>
                <div>Dear <b>FirstName,</b></div>
                <br>
                <div>
                    The management of Coloredcow Consulting Private Limited (hereinafter referred to as the "Company") takes pleasure in appointing you as a <b>"Software Developer"</b> based at the Gurugram Office of the Company on a salary package of <b>4.24 L</b> Lakhs per annum.
                </div>
                <br>
                <div class="revised-details">
                    Your revised remuneration will be <b>INR 35,138/-</b> per month as per the following breakup.
                    <br>
                    <div class="salary-details">
                        <span class="salary-text">Basic Salary</span><span class="salary-number-1">Rs 16,500/-</span>
                    </div>
                    <div class="salary-details">
                        <span class="salary-text">HRA. Allowance</span><span class="salary-number-2">Rs 8350/-</span>
                    </div>
                    <div class="salary-details">
                        <span class="salary-text">Conveyance Allowance</span><span class="salary-number-3">Rs 1600/-</span>
                    </div>
                    <div class="salary-details">
                        <span class="salary-text">Other Allowance</span><span class="salary-number-4">Rs 6350/-</span>
                    </div>
                    <div class="salary-details">
                        <span class="salary-text">P.F. and Charges (Employer share)</span><span class="salary-number-5">Rs 2138/-</span>
                    </div>
                    <div class="salary-details">
                        <span class="salary-text">Medical Insurance (per month)</span><span class="salary-number-6">Rs 250/-</span>
                    </div>
                </div>
                <br>
                <div>
                    <b>
                        ***Medical insurance of 5 Lakhs, rupees are added to your CTC.
                    </b>
                    <br>
                    <b>
                        ***TDS on the above will be deducted as per the income tax rules.
                    </b>
                </div>
                <br>
                <div>
                    In this regard, you are requested to send a signed copy of the attached Appointment Letter as an acceptance.
                </div>
                <br>
                <div class="signature" style="position: relative;">
                    Yours Sincerely,
                    <br>
                    <div class="signature-text">
                        <span style="display: inline-block; margin-right: 400px;">For Coloredcow Consulting Pvt. Ltd.<br><br><br></span>
                        <div>
                            <div style="position: absolute; top: 10px; left: 120px;">
                                <img src="data:image/png;base64" height="110" width="180">
                            </div>
                            Mohit Sharma,<br>
                            HR, Admin
                        </div>
                    </div>
                    <div class="body-container" style="text-align: center">
                        <br><br><br>
                        <b>
                            ***This is an electronically generated document, hence does not require a signature and stamp
                        </b>
                    </div>
                </div>
            </div>
        </div>
        <div class="page">
            <div class="page-body">
                Hi
            </div>
        </div>
    </div>
</body>

</html>
