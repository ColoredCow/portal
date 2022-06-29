@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'payments'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Payments</h1></div>
        <div class="col-md-6"><a href="{{route('payments.create')}}" class="btn btn-success float-right">Create Payment</a></div>
    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Project</th>
            <th>Invoice sent on</th>
            <th>Payment on</th>
            <th>Amount</th>
        </tr>
        @foreach ($payments as $payment)
            <tr>
                <td>
                    <a href="{{route('payments.edit', $payment)}}">
                        {{optional($payment->invoice->project)->name ?: ($payment->invoice->client->name . ' Projects')}}
                    </a>
                </td>
                <td>
                    {{$payment->invoice->sent_on->format(config('constants.display_date_format'))}}
                </td>
                <td>
                    {{$payment->paid_at->format(config('constants.display_date_format'))}}
                </td>
                <td>
                    {{$payment->currency}} {{$payment->amount}}
                </td>
            </tr>
        @endforeach
    </table>
    {{ $payments->links() }}
</div>
@endsection
