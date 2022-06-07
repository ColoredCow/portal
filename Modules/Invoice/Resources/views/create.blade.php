@extends('invoice::layouts.master')
@section('content')

<div class="container">
    <br>
    @if(auth()->user()->can('finance_invoices.create'))
        <h4>Add new Invoice</h4>
        <form method="POST" action="{{ route('invoice.store') }}" id="invoice_form" enctype="multipart/form-data">
            @csrf
            <div class="card">
                @include('status', ['errors' => $errors->all()])
                @include('invoice::subviews.create.invoice-details')
            </div>
        </form>
    @else
        @include('errors.403')
    @endif
</div>
@endsection
