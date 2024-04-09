<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <style>
        body{
            font-family: sans-serif;
        }

        .cc-image {
        text-align: center;
        }

        .cc-image img {
            display: inline-block;
        }
        .body-container{
            padding-left: 20px;
            padding-right: 20px;
        }
        .confidential-text{
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            padding-top: 20px;
            text-align: center;
            text-decoration: underline;
        }
        .date{
            display: flex;
            font-size: 14px;
            padding-top: 25px;
            justify-content: flex-end;
        }
        .user-details{
            font-size: 14px;
            padding-top: 20px;
        }
        .name{
                font-weight: bold;
            }
        .address{
                font-weight: bold;
        }
        .pay-details{
            font-size: 14px;
            line-height: 20px
        }
        table {
            border-collapse: collapse;
        }
        td {
            border: 2px solid black;
            padding: 18px;
        }
        .revised-details{
            padding-top: 20px;
            font-size: 14px;
        }
        .salary-details{
            font-size: 14px;
            padding-top: 18px;
            display: flex;
            justify-content: space-between;
        }
        .paddingTop{
            padding-top: 20px;
        }
        .content-font-size{
            font-size:14px;
            line-height: 20px;
        }
        .salary-text{
            margin-left: 120px;
        }
        .salary-number {
            align-self: center;
        }
        .salary-number-1{
            margin-left: 178px;
        }
        .salary-number-2{
            margin-left: 154px;
        }

        .salary-number-3{
            margin-left: 109px;
        }
        .salary-number-4{
            margin-left: 154px;
        }
        .salary-number-5{
            margin-left:38px;
        }
        .table-content{
            text-align: center;
        }

        .signature{
            font-weight: bold;
            font-size: 14px;
        }
        .signature-text{
            display: flex;
            justify-content: space-between;
        }

        footer {
            position: fixed;
            bottom: -280px;
            text-align: center;
        }

    </style>
</head>

<body>
    <div class="body-container">
        <div class="cc-image">
            <img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" height="50" width="200">
        </div>
        <hr></hr>
        <div class="confidential-text">Confidential</div>
        <div class="date" style="display: block; float: right;" >Date: <b>{{ $data->commencementDate }}</b></div>
        <div class="user-details">
            To<br>
            <span class="name">{{ $data->employeeName }}</span>,<br>
            <span class="address">{{ $data->address }}</span>
        </div>
        <div class="user-details name">Dear {{ $data->employeeFirstName }},</div>
        <div class="pay-details">
            The management of ColoredCow Consulting Pvt. Ltd. takes pleasure in informing you that
            your remuneration has been appraised with {{ $data->salaryIncreasePercentage }} w.e.f <b>{{ $data->commencementDate }}</b>. Below are the
            details of the pay raise.
        </div>
        <div class="paddingTop content-font-size">
            <table>
                <tr>
                  <td class="table-content"><b>Current CTC</b></td>
                  <td class="table-content"><b>New CTC</b></td>
                  <td class="table-content"><b>Increase in %age</b></td>
                  <td class="table-content"><b>Effective Date</b></td>
                </tr>
                <tr>
                  <td class="table-content"><b>{{ $data->previousSalary }}/-</b></td>
                  <td class="table-content"><b>{{ $data->annualCTC}}/- </b></td>
                  <td class="table-content"><b>{{ $data->salaryIncreasePercentage }}</b></td>
                  <td class="table-content"><b>{{ $data->commencementDate}}</b></td>
                </tr>
              </table>
        </div>
        <div class="revised-details">
            Your revised remuneration will be <b>INR {{ $data->grossSalary}}/-</b> per month as per the following breakup.<br>
            <div class="salary-details">
            <span class="salary-text">Basic Salary</span><span class="salary-number-1">{{ $data->basicSalary }}/-</span><br>
            </div>
            <div class="salary-details">
            <span class="salary-text">HRA. Allowance</span><span class="salary-number-2">{{ $data->hra }}/-</span>
            </div>
            <div class="salary-details">
                <span class="salary-text">Conveyance Allowance</span><span class="salary-number-3">{{ $data->tranportAllowance }}/-</span>
            </div>
            <div class="salary-details">
                <span class="salary-text">Other Allowance</span><span class="salary-number-4">{{ $data->otherAllowance }}/-</span>
            </div>
            <div class="salary-details">
                <span class="salary-text" >P.F. and Charges(Employer share)</span><span class="salary-number-5">{{ $data->employeeShare }}/-</span>
            </div>
        </div>
        <div class="paddingTop content-font-size"><b>***Additional Medical insurance of 5 Lakhs, rupees are added to your CTC.</b></div>
        <div class="content-font-size">
            <b>
                ***TDS on the above will be deducted as per the income tax rules.
            </b>
        </div>
        <div class="paddingTop content-font-size">
            The Company may terminate employment Agreement by serving a notice giving 1 month's
            notice and the Employee may terminate this Agreement by giving 1 month's notice.
        </div>
        <div class="paddingTop content-font-size">
            Please note that the other terms and conditions of employment mentioned in the appointment
            letter issued to you earlier remain unchanged.
        </div>
        <div class="paddingTop content-font-size">
            Please sign and return the duplicate of this letter as acceptance of the same.
        </div>
        <div class="paddingTop content-font-size">
            <b>
                We wish you all the very best.
            </b>
        </div><br><br>
        <div class="signature">
            Yours Sincerely,<br>
            <div class="signature-text">
                <span style="display: inline-block; margin-right: 400px;">For Coloredcow Consulting Pvt. Ltd.<br><br><br></span>
                <div style="display: block; float: right;">{{$data->employeeName}}</div>
            <div>
            Mohit Sharma,<br>
            HR, Admin
        </div>
    </div>
</body>
<footer style="float: bottom">
    ColoredCow Consulting Pvt. Ltd. | +91 9818571035 | contact@coloredcow.com | F-61 Suncity,
    Sector 54, Gurgaon, India | CIN No. U72900HR2019PTC081234 | https://coloredcow.com/
</footer>
</html>
