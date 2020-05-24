@extends('invoice::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    @include('invoice::index-menu')
    <br>
    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1">{{ config('invoice.status')[request()->input('status', 'sent')] }} Invoices
            ({{ $invoices ? $invoices->count() : ''}})</h4>
        <span>
            <a href="{{ route('invoice.create') }}" class="btn btn-info text-white"> Add new invoice</a>
        </span>
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Project</th>
                    <th>Status</th>
                    <th>Sent On</th>
                    <th>Due Date</th>
                    <th>File Path</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($invoices as $invoice)
                <tr>
                    <td>
                        <a href="{{ route('invoice.edit', $invoice) }}">{{ $invoice->project->name }}</a>
                    </td>
                    <td>{{ Str::title($invoice->status) }}</td>
                    <td>{{ $invoice->sent_on->format('Y-m-d') }}</td>
                    <td>{{ $invoice->due_on->format('Y-m-d')  }}</td>
                    <td><a href="{{ route('invoice.get-file', $invoice->id) }}">Link</a></td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>

@endsection