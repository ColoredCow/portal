@extends('invoice::layouts.master')
@section('content')

<div class="container">
    <br>
    @if(auth()->user()->can('finance_invoices.create'))
        <h4>Add new Invoice</h4>
        <form method="POST" action="{{ route('invoice.send-invoice-mail') }}" id="invoiceForm">
            @csrf
            <div class="card">
                @include('status', ['errors' => $errors->all()])
                @include('invoice::subviews.create.custom-invoice')
            </div>
        </form>
    @else
        @include('errors.403')
    @endif
</div>
@endsection
