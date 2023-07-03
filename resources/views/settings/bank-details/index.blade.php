@extends('layouts.app')

@section('content')
    <h1>Bank Details</h1>

    <a href="{{ route('bank-details.create') }}" class="btn btn-primary mb-3">Add Bank Detail</a>
    @if(session('success'))
        <div class="alert alert-success" id="successMessage">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Label</th>
                <th>Value</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bankDetails as $bankDetail)
                <tr>
                    <td>{{ $bankDetail->id }}</td>
                    <td>{{ $bankDetail->label }}</td>
                    <td>{{ $bankDetail->value }}</td>
                    <td>
                        <a href="#" class="editBankDetail-btn" data-target="#editBankDetailModal" data-id="{{ $bankDetail->id }}" data-label="{{ $bankDetail->label }}" data-value="{{ $bankDetail->value }}">
                            Edit
                        </a>
                    </td>
                </tr>     
            @endforeach
        </tbody>
    </table>

    <!-- Edit Modal -->
    <div class="modal fade" id="editBankDetailModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Bank Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('bank-details.update', ['bankDetail' => '__bankDetailId__']) }}" method="POST" id="editBankDetailForm">
                        @csrf
                        <div class="form-group">
                            <label for="editBankDetailLabel">Label:</label>
                            <input type="text" class="form-control" id="editBankDetailLabel" name="label" required>
                        </div>
                        <div class="form-group">
                            <label for="editBankDetailValue">Value:</label>
                            <input type="text" class="form-control" id="editBankDetailValue" name="value" required>
                        </div>
                        <input type="hidden" id="editBankDetailId" name="id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveBankDetailChanges">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@yield('scripts')
@endsection
