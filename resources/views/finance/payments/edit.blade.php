@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'payments'])
    <br><br>
    <h1>Edit Payment</h1>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="{{ route('payments.update', $payment) }}" method="POST" id="form_payment" class="form-invoice form-create-invoice">
            @csrf
            @method('PATCH')
            <payment
                :is-new="false"
                :payment="{{json_encode($payment)}}"
                :unpaid-invoices="{{json_encode($unpaidInvoices)}}">
            </payment>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
