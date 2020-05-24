@extends('invoice::layouts.master')
@section('content')

<div class="container">
    <br>
    <h4>Add new Invoice</h4>
    <form method="POST" action="{{ route('invoice.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            @include('status', ['errors' => $errors->all()])
            @include('invoice::subviews.create.invoice-details')
        </div>
    </form>

</div>

@endsection