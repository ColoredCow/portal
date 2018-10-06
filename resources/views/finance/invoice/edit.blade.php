@extends('layouts.app')

@section('content')
<div class="container" id="form_invoice">
    <br>
    @include('finance.menu', ['active' => 'invoices'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Edit Invoice</h1></div>
        <div class="col-md-6"><a href="{{ route('invoices.create') }}" class="btn btn-success float-right">Create Invoice</a></div>
    </div>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="{{route('invoices.update', $invoice)}}" method="POST" enctype="multipart/form-data" class="form-invoice">
            @csrf
            @method('PATCH')
            <invoice :clients="{{json_encode($clients)}}" :invoice="{{json_encode($invoice)}}"></invoice>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
