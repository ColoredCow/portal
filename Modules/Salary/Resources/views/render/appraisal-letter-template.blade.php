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
            border: 1px solid black;
            padding: 5px;
        }
        .revised-details{
            padding-top: 20px;
            font-size: 14px;
        }
        .salary-details{
            text-align: center;
            font-size: 14px;
        }
        .paddingTop{
            padding-top: 20px;
        }
        .content-font-size{
            font-size:14px;
            line-height: 20px;
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
        <div class="date">Date: <b>{{ $data->commencementDate }}</b></div>
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
                  <td>Current CTC</td>
                  <td>New CTC</td>
                  <td>Increase in %age</td>
                  <td>Effective Date</td>
                </tr>
                <tr>
                  <td>{{ $data->previousSalary }}</td>
                  <td>{{ $data->annualCTC}}/-</td>
                  <td>{{ $data->salaryIncreasePercentage }}</td>
                  <td>{{ $data->commencementDate}}</td>
                </tr>
              </table>
        </div>
        <div class="revised-details">
            Your revised remuneration will be <b>INR {{ $data->grossSalary}}/-</b> per month as per the following breakup.<br>
            <div class="salary-details">
            <span>Basic Salary</span><span>{{ $data->basicSalary }}/-</span><br>
            </div>
            <div class="salary-details">
            <span >HRA. Allowance</span><span>{{ $data->hra }}/-</span>
            </div>
            <div class="salary-details">
                <span >Conveyance Allowance</span><span>{{ $data->tranportAllowance }}/-</span>
            </div>
            <div class="salary-details">
                <span >Other Allowance</span><span>{{ $data->otherAllowance }}/-</span>
            </div>
            <div class="salary-details">
                <span >P.F. and Charges (Employer share)</span><span>{{ $data->employeeShare }}/-</span>
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
        </div>
    </div>
</body>

</html>
