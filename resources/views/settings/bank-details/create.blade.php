<!-- bank-details/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Bank Detail</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="bank-details-form" action="{{ route('bank-details.store') }}" method="POST">
        @csrf
        <div class="form-group col-md-6">
            <label for="label">Label:</label>
            <input type="text" class="form-control" id="label" name="label" required>
        </div>
        <div class="form-group col-md-6">
            <label for="key">Key:</label>
            <input type="text" class="form-control" id="key" name="key" required>
        </div>
        <div class="form-group col-md-6">
            <label for="value">Value:</label>
            <input type="text" class="form-control" id="value" name="value" required>
        </div>
        <div class="text-center col-md-6">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>


{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

<script>
    $(document).ready(function() {
        $('#label').on('input', function() {
            var label = $(this).val();
            var key = slugify(label);
            $('#key').val(key);
        });

        function slugify(text) {
            return text.toLowerCase().replace(/[^\w\s-]/g, '').replace(/[\s_-]+/g, '-').trim();
        }

        $('#bank-details-form').submit(function(event) {
            event.preventDefault(); // Prevents the form from submitting automatically

            // Perform any additional validation or actions here before submitting the form

            this.submit(); // Manually trigger the form submission
        });
    });
</script>

@endsection

