@extends('legaldocument::layouts.master')

@section('content')
<div class="container">
    @include('legaldocument::nda.menu')
    <br>
    <div class="d-flex justify-content-start row flex-wrap">

        @include('legaldocument::nda.templates.index')

    </div>
</div>
@endsection
