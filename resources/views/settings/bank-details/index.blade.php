<!-- bank-details/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Bank Details</h1>

    <a href="{{ route('bank-details.create') }}" class="btn btn-primary mb-3">Add Bank Detail</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Key</th>
                <th>Label</th>
                <th>Value</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bankDetails as $bankDetail)
                <tr>
                    <td>{{ $bankDetail->id }}</td>
                    <td>{{ $bankDetail->key }}</td>
                    <td>{{ $bankDetail->label }}</td>
                    <td>{{ $bankDetail->value }}</td>
                    <td>{{ $bankDetail->created_at->format('Y-m-d') }}</td>
                    <td>{{ $bankDetail->updated_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
