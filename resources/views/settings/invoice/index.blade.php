@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Mail Templates</h1>
    <br>
    @include('status', ['errors' => $errors->all()])
    <br>
    @include('settings.invoice.send-invoice')
</div>
@endsection
