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
    <form action="{{route('payments')}}" method="GET" class="form-inline mt-4 mb-4 d-flex justify-content-end">
        <div class="form-group">
            <input type="date" name="start" id="start" placeholder="dd/mm/yyyy" class="form-control form-control-sm" value="{{ $startDate ?? '' }}">
        </div>
        <div class="form-group ml-2">
            <input type="date" name="end" id="end" placeholder="dd/mm/yyyy" class="form-control form-control-sm" value="{{ $endDate ?? '' }}">
        </div>
        <div class="form-group ml-2">
            <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
        </div>
    </form>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Invoice</th>
            <th>Project</th>
            <th>Paid on</th>
        </tr>
        @foreach ($payments as $payment)
            <tr>
                <td>
                    <a href="{{route('payments.edit', $payment)}}">{{$payment->id}}</a>
                </td>
                <td>
                    <a href="{{route('payments.edit', $payment)}}">{{$payment->id}}</a>
                </td>
                <td>
                    {{$payment->paid_at->format('d/m/Y')}}
                </td>
            </tr>
        @endforeach
    </table>
    {{ $payments->links() }}
</div>
@endsection
