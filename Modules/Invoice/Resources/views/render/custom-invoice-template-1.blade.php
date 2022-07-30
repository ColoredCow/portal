<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Styles -->
        <style>
            .d-block {
                display: block;
            }
            .text-center {
                text-align: center;
            }
            .text-right{
                text-align: right;
            }
            .text-left {
                text-align: left;
            }
            .font-weight-bold {
                font-weight: bold;
            }
            .w-100p {
                width: 100%;
            }
            .w-68p {
                width: 68%;
            }
            .w-70p {
                width: 70%;
            }
            .w-75p {
                width: 75%;
            }
            .w-76p {
                width: 76%;
            }
            .p-5 {
                padding: 5px;
            }
            .mt-10 {
                margin-top: 10px;
            }
            .ml-25 {
                margin-left: 25px;
            }
            .underline {
                text-decoration: underline;
            }
            .page {
                page-break-after: always;
                page-break-inside: avoid;
            }
            .table-border, .table-border th, .table-border td {
                border: 2px solid black;
                border-collapse: collapse;
            }
            .table-padding {
                padding-left: 7%; 
                padding-right: 7%;
            }
        </style>
    </head>
    <body>
        <div class="w-100p page">
            <table class="w-100p">
                <tbody>
                    <th>
                        <img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250">
                    </th>
                </tbody>
            </table>
            <div class="table-padding">
                <table class="w-100p">
                    <tbody>
                        <tr>
                            <h2 class="text-center underline font-weight-bold">INVOICE</h2>
                        </tr>
                    </tbody>
                </table>
                <table >
                    <tbody class="w-100p">
                        <tr class="w-100p">
                            <td class="w-68p">Date</td>
                            <td class="text-right">Invoice No: {{ $invoiceNumber }}</td>
                        </tr>
                        <tr class="w-100p">
                            <td style=""> {{ today()->format('m/d/Y') }} </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <br>
                <table>
                    <tbody class="w-100p">
                        <tr class="w-100p">
                            <div class="font-weight-bold">Dasra</div>
                            <div>{{ optional($client->addresses->first())->address }}</div>
                            <div>{{ optional($client->addresses->first())->city . ', ' . optional($client->addresses->first())->state . ', ' . optional($client->addresses->first())->area_code }}</div>
                        </tr>
                    </tbody>
                </table>
                <br>
                <br>
                <table>
                    <tbody class="w-100p">
                        <tr class="w-100p">
                            <div class="font-weight-bold underline text-center">
                                Re: Support and Development for {{ $client->name }} Projects
                            </div>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table>
                    <tbody class="w-100p">
                        <tr class="w-100p">
                            <td class="underline font-weight-bold" style="width: 84%;">Particulars</td>
                            <td class="underline font-weight-bold">Amount ({{ $client->country->currency }})</td>
                        </tr>
                        <tr>
                            <br>
                        </tr>
                        <tr>
                            <td>
                                <div>
                                    Support and Development for below projects:
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="w-100p ml-25 mt-10">
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td class="w-76p">
                                    <div>
                                        {{ $loop->iteration . __('. ') . $project->name . __(' (Q') . ceil(now()->month / 3) . __(')') }}
                                    </div>
                                </td>
                                <td>
                                    {{ $client->country->currency_symbol . $project->getTotalLedgerAmount() }}
                                </td>
                            </tr>
                            <tr></tr>
                        @endforeach
                        <tr>
                            <td>
                            </td>
                            <td>
                                {{ __('---------') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="w-75p">
                                <div class="font-weight-bold">
                                    {{ __('Total') }}
                                </div>
                            </td>
                            <td>
                                {{ $client->country->currency_symbol . $client->getClientProjectsTotalLedgerAmount() }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p></p>
                <table class="w-100p">
                    <tbody>
                        <td>
                            <p>{{ __('Refer table below for Details') }}</p>
                            <p><br></p>
                            <p>{{ __('For Company ') . config('invoice.coloredcow-details.name') }}</p>
                            <p>{{ 'Address: ' . config('invoice.coloredcow-details.gurgaon.address-line-1') . ', ' . config('invoice.coloredcow-details.gurgaon.address-line-2') }}</p>
                            <p>{{ __('Bank Name: ') . config('invoice.finance-details.bank-address') }}</p>
                            <p>{{ __('A/C No: ') . config('invoice.finance-details.account-number') }}</p>
                            <p>{{ __('IFSC: ') . config('invoice.finance-details.ifci-code') }}</p>
                            <p>{{ __('SWIFT Code: ') . config('invoice.finance-details.swift-code') }}</p>
                            <p>{{ __('Correspondent Bank: ') . config('invoice.finance-details.correspondent-bank') }}</p>
                            <p>{{ __('SWIFT Code: ') . config('invoice.finance-details.correspondent-bank-swift-code') }}</p>
                            <p>{{ __('Beneficiary Bank of USD: ') . config('invoice.finance-details.beneficiary-bank-of-usd') }}</p>
                            <p>{{ __('GSTIN: ') . config('invoice.finance-details.gstin') }}</p>
                        </td>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="w-100p">
            <table class="w-100p">
                <tbody>
                    <th>
                        <img src="{{ public_path() . '/images/coloredcow.png' }}" alt="" align="right" height="50" width="250">
                    </th>
                </tbody>
            </table>
            <div class="table-padding">
                <table>
                    <tbody>
                        <tr>
                            <p>
                                <br>
                            </p>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">
                                {{ __('Invoice Breakdown') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p></p>
                <table class="table-border w-100p">
                    <tbody>
                        @foreach ($projects as $project)
                            @foreach ($project->ledgerAccountsOnlyCredit as $ledgerAccountRow )
                                <tr>
                                    <td class="p-5 w-70p">
                                        {{ $ledgerAccountRow->particulars }}
                                    </td>
                                    <td class="p-5 text-right">
                                        {{ $client->country->currency_symbol . $ledgerAccountRow->credit }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        <tr class="font-weight-bold">
                            <td class="p-5 w-70p">
                                {{ __('Total: ') }}
                            </td>
                            <td class="p-5 text-right">
                                {{ $client->country->currency_symbol . $client->ledgerAccountsOnlyCredit->sum('credit') }}
                            </td>
                        </tr>
                        @foreach ($projects as $project)
                            @foreach ($project->ledgerAccountsOnlyDebit as $ledgerAccountRow)
                                <tr>
                                    <td class="p-5 w-70p">
                                        {{ $ledgerAccountRow->particulars }}
                                    </td>
                                    <td class="p-5 text-right">
                                        {{ __('-') . $client->country->currency_symbol . $ledgerAccountRow->debit }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        <tr class="font-weight-bold">
                            <td class="p-5 w-70p">
                                {{ __('Balance: ') }}
                            </td>
                            <td class="p-5 text-right">
                                {{ $client->country->currency_symbol . ($client->getClientProjectsTotalLedgerAmount()) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>