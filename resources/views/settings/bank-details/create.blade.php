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

    <form action="{{ route('bank-details.store') }}" method="POST">
        @csrf
        <div class="form-group col-md-6">
            <label for="key">Key:</label>
            <input type="text"  class="form-control" id="key" name="key" required>
        </div>
        <div class="form-group col-md-6">
            <label for="label">Label:</label>
            <input type="text" class="form-control" id="label" name="label" required>
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
@endsection

