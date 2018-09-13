@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'payments'])
    <br><br>
    <h1>Create Payment</h1>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="{{ route('payments.store') }}" method="POST" id="form_payment" class="form-invoice form-create-invoice">
            @csrf
            <payment :is-new="true" :unpaid-invoices="{{json_encode($unpaidInvoices)}}"></payment>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection
