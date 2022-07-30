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
                font-family: sans-serif;
                line-height: 1.15;
                -webkit-text-size-adjust: 100%;
                -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
                margin: 0;
                padding: 0;
                height: 100%;
                background-size: 100% 100%;
                font-size: 12px;
                background: white !important;
            }
            footer {
                margin-top: 50px; 
                color:gray;
            }
            footer p {
                text-align: center;
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
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
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
            tr, td{
                padding: 0.2em 0 0.2em 1em !important;
                margin: 0.2em 0 0.2em 1em !important;
            }
            table {
                border-collapse: collapse;
            }
            thead {
                display: table-header-group;
            }
            .table .thead-dark th {
                color: #fff;
                background-color: #343a40;
                border-color: #454d55;
                padding-top: 10px;
                padding-bottom: 10px;
                padding-left: 10px
            }
            .table thead th {
                vertical-align: bottom;
                border-bottom: 2px solid #dee2e6;
            }
            .border-bottom td{
                vertical-align: bottom;
                border-bottom: 1px solid #dee2e6;
                padding-bottom: 4px !important;
                padding-top: 4px !important;
            }
            .table-borderless th,
            .table-borderless td,
            .table-borderless thead th,
            .table-borderless tbody + tbody {
                border: 0;
            }
            td p {
                margin-top: 5px !important;
                margin-bottom: 5px !important;
            }
            .table-borderless tbody td p {
                margin-top: 1.5px !important;
                margin-bottom: 1.5px !important;
            }
            .stamp {
                float: right; 
                margin-top: -95px; 
                margin-left: 170px;
            }
            .transaction-details th {
                padding-left: 10px; padding-bottom:10px;
            }
            .w-100p {
                width: 100%;
            }
            .w-70p {
                width: 70%;
            }
            .w-40p {
                width: 40%;
            }
            .w-60p {
                width: 60%;
            }
            .w-67p {
                width: 67%;
            }
            .w-135 {
                width: 135px;
            }
            .w-94 {
                width: 94px;
            }
        </style>
    </head>
    <body>
        <header>
            @php
                $currencySymbol = $client ? $client->country->currency_symbol : $project->client->country->currency_symbol;
            @endphp
            <div class="w-100p">
                <h2 style="text-align: center; font-weight: bold;">INVOICE</h2>
                <table>
                    <tbody>
                        <tr valign="top">
                            <td>
                                <img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" height="50" width="200">
                            </td>
                            <td style="color: grey;" align="right">
                                <p>{{ config('invoice.coloredcow-details.gurgaon.address-line-1') }}</p>
                                <p>{{ config('invoice.coloredcow-details.gurgaon.address-line-2') }}</p>
                                <p>finance@coloredcow.com</p>
                                <p>{{ str_replace('-', ' ', config('invoice.finance-details.phone')) }}</p>
                                <p>PAN : {{ config('invoice.finance-details.pan') }}</p>
                                <p>GSTIN : {{ config('invoice.finance-details.gstin') }}</p>
                                <p>SAC / HSN code : {{ config('invoice.finance-details.hsn-code') }}</p>
                                <p>CIN No. {{ config('invoice.finance-details.cin-no') }}</p>
                                <p><br><br><br></p>
                            </td>
                        </tr>
                        <tr class="w-100p">
                            <td align="left" class="w-70p">
                                <p class="fw-bold">Bill To</p>
                                <p>{{ optional($client->billing_contact)->name }}</p>
                                <p>{{ $client->name }}</p>
                                <p>{{ optional($client->billing_contact)->email }}</p>
                                <p>{{ optional($client->addresses->first())->address }}</p>
                                <p>{{ optional($client->addresses->first())->city . ', ' . optional($client->addresses->first())->state . ', ' . optional($client->addresses->first())->area_code }}</p>
                                <p>{{ $client->country->initials == 'IN' && optional($client->addresses->first())->gst_number ? __('GSTIN: ') . optional($client->addresses->first())->gst_number : '' }}</p>
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
                                            <p>{{ $termText }}</p>
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
                                            <p><strong>
                                                @if($billingLevel == 'client') 
                                                    @if(optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug'))
                                                        {{ '' }}
                                                    @else
                                                        {{ $currencySymbol . $client->getTotalPayableAmountForTerm($monthsToSubtract, $projects) }}
                                                    @endif
                                                @else 
                                                    @if(optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug'))
                                                        {{ $currencySymbol . $project->getResourceBillableAmount() }}
                                                    @else
                                                        {{ $currencySymbol . $project->getBillableHoursForMonth($monthsToSubtract) }}
                                                    @endif     
                                                @endif
                                            </strong></p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                @if(optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug'))
                    @include('invoice::render.resource-based-billing-template')
                @else 
                    @include('invoice::render.international-hourly-billing-template')
                @endif
                <div><br>
                    <table class="table w-67p" style="margin-left:33%;">
                        <tr class="border-bottom" >
                            <td class="w-135">Total</td>
                            <td class="w-94">
                                @if($billingLevel == 'client') 
                                    @if(optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug'))
                                        {{ '' }}
                                    @else
                                        {{ $client->getClientLevelProjectsBillableHoursForInvoice($monthsToSubtract) }}
                                    @endif
                                @else 
                                    @if(optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug'))
                                        {{ '' }}
                                    @else
                                        {{ $project->getBillableHoursForMonth($monthsToSubtract)  }}
                                    @endif     
                                @endif
                            </td>
                            <td class="w-135"></td>
                            <td>
                                @if($billingLevel == 'client') 
                                    @if(optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug'))
                                        {{ '' }}
                                    @else
                                        {{ $client->getBillableAmountForTerm($monthsToSubtract, $projects) + optional($client->billingDetails)->bank_charges }}
                                    @endif
                                @else 
                                    @if(optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug'))
                                        {{ $project->getResourceBillableAmount() }}
                                    @else
                                        {{ $project->getBillableAmountForTerm($monthsToSubtract) + optional($project->client->billingDetails)->bank_charges }}
                                    @endif     
                                @endif
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td>{{ $client->country->initials == 'IN' ? __('GST in INR') : __('IGST') }}</td>
                            <td></td>
                            <td>{{ $client->country->initials == 'IN' ? config('invoice.invoice-details.igst') : __('NILL') }}</td>
                            <td>{{ $currencySymbol . ($billingLevel == 'client' ? $client->getTaxAmountForTerm($monthsToSubtract, $projects) : $project->getTaxAmountForTerm($monthsToSubtract)) }}</td>
                        </tr>
                        <tr>
                            <td>Current Payable</td>
                            <td></td>
                            <td></td>
                            <td>
                                @if($billingLevel == 'client') 
                                    @if(optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug'))
                                        {{ '' }}
                                    @else
                                        {{ $currencySymbol . $client->getTotalPayableAmountForTerm($monthsToSubtract, $projects) }}
                                    @endif
                                @else 
                                    @if(optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug'))
                                        {{ currencySymbol . $project->getResourceBillableAmount() }}
                                    @else
                                        {{ currencySymbol . $project->getTotalPayableAmountForTerm($monthsToSubtract) }}
                                    @endif     
                                @endif
                            </td>
                        </tr>
                        <tr><td><br></td></tr>
                        <tr class="border-bottom">
                            <td>Amount Paid</td>
                            <td></td>
                            <td></td>
                            <td>{{ $currencySymbol . $client->getAmountPaidForTerm($monthsToSubtract, $projects) }}</td>
                        </tr>
                        <tr class="border-bottom">
                            <td>
                                <strong>Amount Due in {{ $client->country->initials . ' ' . $currencySymbol }}</strong>
                            </td>
                            <td></td>
                            <td></td>
                            <td><strong>
                                @if($billingLevel == 'client') 
                                    @if(optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug'))
                                        {{ '' }}
                                    @else
                                        {{ $currencySymbol . $client->getTotalPayableAmountForTerm($monthsToSubtract, $projects) }}
                                    @endif
                                @else 
                                    @if(optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug'))
                                        {{ currencySymbol . $project->getResourceBillableAmount() }}
                                    @else
                                        {{ currencySymbol . $project->getTotalPayableAmountForTerm($monthsToSubtract) }}
                                    @endif     
                                @endif
                            </strong></td>
                        </tr>
                    </table>
                </div>
                    <br>
                    <table class="table-borderless transaction-details w-60p">
                        <thead>
                            <tr>
                                <th class="fz-16" align="left">Transaction Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="w-40p" >Transaction Method:</td>
                                <td>{{ config('invoice.finance-details.transaction-method.value.bank-transfer.value') }}</td>
                            </tr>
                            <tr>
                                <td class="w-40p">Bank Name:</td>
                                <td>{{ config('invoice.finance-details.bank-address') }}</td>
                            </tr>
                            <tr>
                                <td class="w-40p">Swift Code:</td>
                                <td>{{ config('invoice.finance-details.swift-code') }}</td>
                            </tr>
                            <tr>
                                <td class="w-40p">Bank/IFCI Code:</td>
                                <td>{{ config('invoice.finance-details.ifci-code') }}</td>
                            </tr>
                            <tr>
                                <td class="w-40p">Account Number:</td>
                                <td>{{ config('invoice.finance-details.account-number') }}</td>
                            </tr>
                            <tr>
                                <td class="w-40p">A/C Holder Name:</td>
                                <td>{{ config('invoice.finance-details.holder-name') }}</td>
                            </tr>
                            <tr>
                                <td class="w-40p">Phone:</td>
                                <td>{{ config('invoice.finance-details.phone') }}</td>
                            </tr><br>
                            <tr><td><br></td></tr>
                            <tr>
                                <td colspan="2">
                                    <a href="{{ $billingLevel == 'client' ? $client->effort_sheet_url : $project->effort_sheet_url }}" target="_blank">For more details of this invoice you can visit this sheet.</a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Thank you for your business. It’s a pleasure to work with you on your project.
                                </td>
                            </tr>
                            <tr><td><br></td></tr>
                            <tr>
                                <td>
                                    <p>Sincerely,</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p>{{ config('invoice.coloredcow-details.name') }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p>{{ config('invoice.coloredcow-details.gurgaon.address-line-1') }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p>{{ config('invoice.coloredcow-details.gurgaon.address-line-2') }}</p>
                                </td>
                            </tr>
                            <tr colspan="2">
                                <td>
                                    <img class="stamp" src="{{ storage_path('app/stamp/coloredcow-stamp.png') }}" alt="" height="100" width="100">     
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </header>
        <footer >
            <p>{{ __('This is a system generated invoice and need not be signed.') }}</p>
        </footer>
    </body>
</html>