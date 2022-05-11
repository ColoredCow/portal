@extends('invoice::layouts.master')
@section('content')

<div class="mx-15" id="vueContainer">
    <br>
    <br>

    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1">              Invoice Details</h4>
    </div>
    <br>
    <br>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th></th>
                    <th>Date</th>
                    <th>Particular</th>
                    <th>Type</th>
                    <th>INVOICE NO.</th>
                    <th>GST</th>
                    <th>INVOICE VALUE</th>
                    <th>RATE</th>
                    <th>RECEIVABLE AMOUNT</th>
                    <th>TAXABLE AMOUNT</th>
                    <th>IGST</th>
                    <th>CGST</th>
                    <th>SGST</th>
                    <th>HSN Code</th>
                </tr>
            </thead>

            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td>
                        {{ $loop->iteration }} 
                        <td>{{ $invoice->sent_on->toDateString() }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        @if($invoice->currency == "USD")
                            <td>{{ config('invoice.invoice-details.igst') }}</td>
                        @else
                            <td></td>
                        @endif
                        @if($invoice->currency == "INR")
                            <td>{{ config('invoice.invoice-details.cgst') }}</td>
                            <td>{{ config('invoice.invoice-details.sgst') }}</td>
                        @else
                        <td></td>
                        <td></td>
                        @endif
                        <td></td>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

@endsection