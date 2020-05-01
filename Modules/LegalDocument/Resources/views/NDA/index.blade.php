@extends('legaldocument::layouts.master')

@section('content')
<div class="container">
    @include('legaldocument::NDA.menu')
    <br>
    <div class="d-flex justify-content-start row flex-wrap">

        @include('legaldocument::NDA.templates.index')

    </div>
</div>
@endsection