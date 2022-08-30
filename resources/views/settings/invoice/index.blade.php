@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Mail Templates</h1>
    <br>
    @include('status', ['errors' => $errors->all()])
    <br>
    @include('settings.invoice.send-invoice')
    <br>
    @include('settings.invoice.send-invoice-reminder')
    <br>
    @include('settings.invoice.received-invoice-payment')
</div>
@endsection
