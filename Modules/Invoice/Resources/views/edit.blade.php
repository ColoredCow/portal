@extends('invoice::layouts.master')
@section('content')

<div class="container">
    <br>

    <div class="d-flex justify-content-between mb-2">
    @if(auth()->user()->can('finance_invoices.update'))
            <h4>Invoice Information</h4>
            <span>
                <a class="btn btn-sm btn-info text-white mr-4 font-weight-bold" onclick="alert('Will add this soon')" href="#">Duplicate this invoice</a>
                <a class="btn btn-sm btn-info text-white font-weight-bold" target="_blank" href="{{ route('invoice.createInvoice', $invoice) }}">Create invoice</a>
            </span>
        </div>
        <form method="POST" action="{{ route('invoice.update', $invoice) }}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                @include('status', ['errors' => $errors->all()])
                @include('invoice::subviews.edit.invoice-details')
            </div>
        </form>
    @else
        @include('errors.403')
    @endif
</div>

@endsection
