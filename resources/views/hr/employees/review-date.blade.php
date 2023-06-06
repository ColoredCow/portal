@extends('layouts.app')

@section('content')
    <div class="container mb-20">
        <br>
        @include('hr.employees.sub-views.menu')
        <br>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div>
            <br>
            @if ($employee->assessments()->first())
                <h2>Update Review Date</h2>
                <br>
                <br>
                <p>Review Date: <span
                        class="text-info">{{ $employee->assessments()->first()->created_at->format('d-m-Y') }}</span></p>

                <form method="POST" action="{{ route('employees.update-review-date', ['employee' => $employee]) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <br>
                        <label for="review_date">New Review Date:</label>
                        <input type="date" class="form-control mt-4" id="review_date" name="review_date" required>
                    </div>
                    <br>
                    <br>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            @else
                <h2>Add Review Date</h2>
                <br>
                <br>
                <form method="POST" action="{{ route('employees.save-review-date', ['employee' => $employee]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="review_date">Review Date:</label>
                        <input type="date" class="form-control mt-4" id="review_date" name="review_date" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Save</button>
                </form>
            @endif
        </div>

    </div>
@endsection
