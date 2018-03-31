@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-md-6"><h1>Invoices</h1></div>
        <div class="col-md-6"><a href="/finance/invoices/create" class="btn btn-success float-right">Create Invoice</a></div>
    </div>
    <br>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Name</th>
            <th>Project</th>
            <th>Status</th>
        </tr>
        @foreach ($invoices as $invoice)
        <tr>
            <td><a href="/finance/invoices/{{ $invoice->id }}/edit">{{ $invoice->name }}</a></td>
            <td>{{ $invoice->project->name }}</td>
            <td>
                @switch ($invoice->status)
                    @case('paid')
                        <span class="badge badge-pill badge-success">
                        @break
                    @case('unpaid')
                        <span class="badge badge-pill badge-danger">
                        @break
                @endswitch
                {{ $invoice->status }}</span>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
