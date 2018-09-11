@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'invoices'])
    <br><br>
    <h1>Create Invoice</h1>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="{{route('invoices.store')}}" method="POST" enctype="multipart/form-data" id="form_invoice" class="form-invoice form-create-invoice">
            @csrf
            <invoice :clients="{{json_encode($clients)}}"></invoice>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection
