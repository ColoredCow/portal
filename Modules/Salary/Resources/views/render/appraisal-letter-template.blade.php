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
    {{-- @dd($data->date) --}}
    <div class="body-container">
        <div class="cc-image">
            <img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" height="50" width="200">
        </div>
        <hr></hr>
        <div class="confidential-text">Confidential</div>
        <div class="date">Date: <b>{{ $data->date }}</b></div>
        <div class="user-details">
            To<br>
            <span class="name">{{ $data->employeeName }}</span>,<br>
            <span class="address">Buxar</span>
        </div>
        <div class="user-details name">Dear {{ $data->employeeName  }},</div>
        <div class="pay-details">
            The management of ColoredCow Consulting Pvt. Ltd. takes pleasure in informing you that
            your remuneration has been appraised with 18.59% w.e.f <b>{{ $data->date }}</b>. Below are the
            details of the pay raise.
        </div>
        <div class="paddingTop content-font-size">
            <table>
                <tr>
                  <td>Row 1, Column 1</td>
                  <td>Row 1, Column 2</td>
                  <td>Row 1, Column 3</td>
                  <td>Row 1, Column 4</td>
                </tr>
                <tr>
                  <td>Row 2, Column 1</td>
                  <td>Row 2, Column 2</td>
                  <td>Row 2, Column 3</td>
                  <td>Row 2, Column 4</td>
                </tr>
              </table>
        </div>
        <div class="revised-details">
            Your revised remuneration will be <b>INR 41,673/-</b> per month as per the following breakup.<br>
            <div class="salary-details">
            <span>Basic Salary</span><span>Rs. 19,575/-</span><br>
            </div>
            <div class="salary-details">
            <span >HRA. Allowance</span><span>Rs. 9,788/-</span>
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
