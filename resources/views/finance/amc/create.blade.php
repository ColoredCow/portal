@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'invoices'])
    <br><br>
    <h1>Setup AMC</h1>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="{{route('amc.store')}}" method="POST" enctype="multipart/form-data" id="form_amc" class="form_amc form-create-amc">
            @csrf
            <amc-form :clients="{{json_encode($clients)}}"></amc-form>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection
