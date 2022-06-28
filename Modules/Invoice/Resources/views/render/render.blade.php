<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ public_path('css/app.css') }}" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <!-- Styles -->
        <style>
            html,
            body {
                color: #012840;
                font-weight: normal;
                margin: 0;
                padding: 0;
                height: 100%;
                background-size: 100% 100%;
                font-size: 12px;
                background: white !important;
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
            .ml-1em {
                margin-left: 1em;
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
                padding-top: 20px !important;
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
            .mt-0 {
                margin-top: 0px !important;
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
            .fw-bold {
                font-weight: bold !important;
            }
            td p {
                margin-top: 1px;
                margin-bottom: 1px;
            }
            tr, td{
                padding: 0.2em 0 0.2em 1em !important;
                margin: 0.2em 0 0.2em 1em !important;
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
                                <img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" height="50" width="200">
                            </td>
                            <td style="color: grey;" align="right">
                                <p>{{ config('invoice.coloredcow-details.address-line-1') }}</p>
                                <p>{{ config('invoice.coloredcow-details.address-line-2') }}</p>
                                <p>finance@coloredcow.com</p>
                                <p>{{ str_replace('-', ' ', config('invoice.finance-details.phone')) }}</p>
                                <p>PAN : {{ config('invoice.finance-details.pan') }}</p>
                                <p>GSTIN : {{ config('invoice.finance-details.gstin') }}</p>
                                <p>SAC / HSN code : {{ config('invoice.finance-details.hsn-code') }}</p>
                                <p>CIN No. {{ config('invoice.finance-details.cin-no') }}</p>
                            </td>
                        </tr>
                        <tr style="width:100%;">
                            <td align="left">
                                <p class="fw-bold">Bill To</p>
                                <p>{{ optional($client->billing_contact)->name }}</p>
                                <p>{{ $client->name }}</p>
                                <p>{{ optional($client->billing_contact)->email }}</p>
                                <p>{{ $client->addresses->first()->address }}</p>
                                <p>{{ $client->addresses->first()->state . ' ' . $client->addresses->first()->area_code }}</p>
                                <p>{{ $client->country->initials == 'IN' ? __('GSTIN: ') . optional($client->addresses->first())->gst_number : '' }}</p>
                                <p>{{ optional($client->billing_contact)->phone }}</p>
                            </td>
                            <td>
                                <p class="fw-bold ml-1em">Details</p>
                                <table>
                                    <tr>
                                        <td>
                                            <p>Term: </p>
                                            <p>Invoice Number: </p>
                                            <p>Issue Date: </p>
                                            <p>Due Date: </p>
                                        </td>
                                        <td align="right">
                                            <p>{{ $monthName }}</p>
                                            <p>{{ $invoiceNumber }}</p>
                                            <p>{{ date('F d, Y', strtotime($invoiceData['sent_on'])) }}</p>
                                            <p>{{ date('F d, Y', strtotime($invoiceData['due_on'])) }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td align="left" class="fw-bold">
                                <p>Client Name: {{ $client->name }}</p>
                                <p>Client ID: {{ sprintf('%03s', $client->client_id) }}</p>
                                @if($billingLevel == config('project.meta_keys.billing_level.value.project.key'))
                                    <p>Project Name: {{ $projects->first()->name }}</p>
                                    <p>Project ID: {{ $projects->first()->client_project_id }}</p>
                                @endif
                                <p>Category: Web Application Development</p>
                            </td>
                            <td align="right">
                                <table>
                                    <tr>
                                        <td>
                                            <p>Total Amount Due :</p>
                                        </td>
                                        <td align="right">
                                            <p><strong>{{ $client->country->currency_symbol . $client->getTotalPayableAmountForTerm($monthNumber, $year, $projects) }}</strong></p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                @include('invoice::render.international-hourly-billing-template')
                <div>
                    <table class="table" style="margin-left: auto;width:50%;">
                        <tr>
                            <td>Total</td>
                            <td></td>
                            <td>{{ $client->country->currency_symbol . $client->getBillableAmountForTerm($monthNumber, $year, $projects) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $client->country->initials == 'IN' ? __('GST in INR') : __('IGST') }}</td>
                            <td>{{ $client->country->initials == 'IN' ? config('invoice.invoice-details.igst') : __('NILL') }}</td>
                            <td>{{ $client->country->currency_symbol . $client->getTaxAmountForTerm($monthNumber, $year, $projects) }}</td>
                        </tr>
                        <tr>
                            <td>Current Payable</td>
                            <td></td>
                            <td>{{ $client->country->currency_symbol . ($client->getBillableAmountForTerm($monthNumber, $year, $projects) + $client->getTaxAmountForTerm($monthNumber, $year, $projects)) }}</td>
                        </tr>
                        <tr>
                            <td>Amount Paid</td>
                            <td></td>
                            <td>{{ $client->country->currency_symbol . $client->getAmountPaidForTerm($monthNumber, $year, $projects) }}</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Current Amount Due in {{ $client->country->initials . ' ' . $client->country->currency_symbol }}</strong>
                            </td>
                            <td></td>
                            <td><strong>{{ $client->country->currency_symbol . $client->getTotalPayableAmountForTerm($monthNumber, $year, $projects) }}</strong></td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table class="table table-borderless" style="width: 50%; margin-right: auto;">
                        <thead>
                            <tr>
                                <th scope="col" class="fz-16">Transaction Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 40%;">Transaction Method:</td>
                                <td>{{ config('invoice.finance-details.transaction-method.value.bank-transfer.value') }}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">Bank Name:</td>
                                <td>{{ config('invoice.finance-details.bank-address') }}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">Swift Code:</td>
                                <td>{{ config('invoice.finance-details.swift-code') }}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">Bank/IFCI Code:</td>
                                <td>{{ config('invoice.finance-details.ifci-code') }}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">Account Number:</td>
                                <td>{{ config('invoice.finance-details.account-number') }}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">A/C Holder Name:</td>
                                <td>{{ config('invoice.finance-details.holder-name') }}</td>
                            </tr>
                            <tr>
                                <td style="width: 40%;">Phone:</td>
                                <td>{{ config('invoice.finance-details.phone') }}</td>
                            </tr><br>
                            <tr><td><br></td></tr>
                            <tr>
                                <td colspan="2">
                                    <a href="{{ $client->effort_sheet_url }}">For more details of this invoice you can visit this sheet.</a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Thank you for your business. It’s a pleasure to work with you on your project.
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class='mb-0 mt-0'>Sincerely,</p>
                                    <p class='mb-0 mt-0'>{{ config('invoice.coloredcow-details.name') }}</p>
                                    <p class='mb-0 mt-0'>{{ config('invoice.coloredcow-details.address-line-1') }}</p>
                                    <p class='mb-0 mt-0'>{{ config('invoice.coloredcow-details.address-line-2') }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </header>
    </body>
</html>