@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'invoices'])
    <br>
    <div class="row">
        <div class="col-md-6"><h1>Invoices</h1></div>
        <div class="col-md-6"><a href="/finance/invoices/create" class="btn btn-success float-right">Create Invoice</a></div>
    </div>
    <br>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Project</th>
            <th>Status</th>
            <th>Sent on</th>
            <th>Invoice File</th>
        </tr>
        @foreach ($invoices as $invoice)
        <tr>
            <td><a href="/finance/invoices/{{ $invoice->id }}/edit">
                @foreach ($invoice->projects as $project)
                    {{ $loop->first ? '' : '|' }}
                    {{ $project->name }}
                @endforeach
            </a></td>
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
            <td>
                {{ date(config('constants.display_date_format'), strtotime($invoice->sent_on)) }}
            </td>
            <td>
            @if ($invoice->file_path)
                <a href="/finance/invoices/download/{{ $invoice->file_path }}"><i class="fa fa-file fa-2x text-primary btn-file"></i></a>
            @else
                <span>-</span>
            @endif
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
