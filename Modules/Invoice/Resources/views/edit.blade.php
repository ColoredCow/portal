@extends('invoice::layouts.master')
@section('content')

<div class="container">
    <br>
    <h4>Update Invoice Info</h4>
    <form method="POST" action="{{ route('invoice.update', $invoice) }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            @include('status', ['errors' => $errors->all()])
            @include('invoice::subviews.edit.invoice-details')
        </div>
    </form>

</div>

@endsection