@extends('invoice::layouts.master')
@section('content')
<div class="d-flex justify-content-between">
    <h4 class="m-1 p-1 fz-28">Clients</h4>
    <span class=d-flex>
        <a href="{{ route('invoice.create-custom-invoice') }}"
            class="btn btn-info text-white m-1 align-self-center">Custom Invoice</a>
        <a href="{{ route('invoice.create') }}" class="btn btn-success text-white m-1 align-self-center"><i
                class="fa fa-plus mr-1"></i>Add Invoice</a>
    </span>
</div>
@php
    $request['status'] = 'sent';
@endphp
<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr class="text-center sticky-top">
            <th></th>
            <th>Client Name</th>
            <th>Total Amount(Incliding GST)</th>
            <th>Pending Invoices</th>
        </tr>
    </thead>
    @foreach ($clientData as $client)
    @php 
        $request['client_id'] = $client['client_id'];
    @endphp
    <tr>
        <td>{{$loop->iteration}}</td>
        <td><a href="{{ route('invoice.invoice-settle', $request) }}">{{$client['name']}}</a></td>
        <td>₹{{$client['total']}}</td>
        <td>{{$client['total_invoices']}}</td>
    </tr>
    @endforeach
</table>
@endsection