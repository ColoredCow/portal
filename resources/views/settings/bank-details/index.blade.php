<!-- bank-details/index.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Bank Details</h1>

    <a href="{{ route('bank-details.create') }}" class="btn btn-primary mb-3">Add Bank Detail</a>

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
                        <a href="#" class="edit-btn" data-id="{{ $bankDetail->id }}" data-label="{{ $bankDetail->label }}" data-value="{{ $bankDetail->value }}">
                            {{-- <i class="fas fa-edit"></i> --}}
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
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
                            <label for="editLabel">Label:</label>
                            <input type="text" class="form-control" id="editLabel" name="label" required>
                        </div>
                        <div class="form-group">
                            <label for="editValue">Value:</label>
                            <input type="text" class="form-control" id="editValue" name="value" required>
                        </div>
                        <input type="hidden" id="editId" name="id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="saveBankDetailChanges">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.edit-btn').click(function() {
                var bankDetailId = $(this).data('id');
                var bankDetailLabel = $(this).data('label');
                var bankDetailValue = $(this).data('value');

                $('#editId').val(bankDetailId);
                $('#editLabel').val(bankDetailLabel);
                $('#editValue').val(bankDetailValue);

                var formAction = '{{ route('bank-details.update', ['bankDetail' => '__bankDetailId__']) }}';
                formAction = formAction.replace('__bankDetailId__', bankDetailId);
                $('#editBankDetailForm').attr('action', formAction);

                $('#editModal').modal('show');
            });
            $(document).ready(function() {
            @if(session('success'))
                alert('{{ session('success') }}');
            @endif
         });
        });
    </script>
@endsection
