@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'invoices'])
    <br><br>
    <h1>Setup AMC</h1>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="{{route('invoices.store')}}" method="POST" enctype="multipart/form-data" id="form_amc" class="form_amc form-create-amc">
            @csrf
            <amc-create :clients="{{json_encode($clients)}}"></amc-create>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection
