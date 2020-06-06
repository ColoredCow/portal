@extends('invoice::layouts.master')
@section('content')

<div class="container">
    <br>
    
    <div class="d-flex justify-content-between mb-2"> 
        <h4>Invoice Information</h4>
        <a class="text-underline" onclick="alert('Will add this soon')" href="#">Duplicate this invoice</a>
    </div>
    <form method="POST" action="{{ route('invoice.update', $invoice) }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            @include('status', ['errors' => $errors->all()])
            @include('invoice::subviews.edit.invoice-details')
        </div>
    </form>

</div>

@endsection