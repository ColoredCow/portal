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
            <h2>{{ $employee->assessments()->first() ? 'Update' : 'Add' }} Review Date</h2>
            <br>
            <br>
            <form method="POST"
                action="{{ $employee->assessments()->first() ? route('employees.update-review-date', ['employee' => $employee]) : route('employees.save-review-date', ['employee' => $employee]) }}">
                @csrf
                @if ($employee->assessments()->first())
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="review_date">Last Review Date:</label>
                    <input type="date" class="form-control mt-1" id="review_date" name="review_date"
                        value="{{ $employee->assessments()->first()? $employee->assessments()->first()->created_at->format('Y-m-d'): '' }}"
                        required>
                </div>
                <br>
                <button type="submit"
                    class="btn btn-primary">{{ $employee->assessments()->first() ? 'Update' : 'Save' }}</button>
            </form>
        </div>

    </div>
@endsection
