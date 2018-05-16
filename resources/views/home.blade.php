@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="d-flex justify-content-between row">
        <div class="col-md-3  card">
            <a class="card-body no-transition" href="/hr/applications/">
                <br><h2 class="text-center">HR</h2><br>
            </a>
        </div>
        <div class="col-md-3 card">
            <a class="card-body no-transition" href="/finance/invoices/">
                <br><h2 class="text-center">Finance</h2><br>
            </a>
        </div>
        <div class="col-md-3 card">
            <a class="card-body no-transition" href="/weeklydoses/">
                <br><h2 class="text-center">WeeklyDose</h2><br>
            </a>
        </div>
    </div>

    <br>

    <div class="d-flex justify-content-between row">
        <div class="col-md-3 card">
            <a class="card-body no-transition" href="/knowledgecafe">
                <br><h2 class="text-center">Knowledge Cafe</h2><br>
            </a>
        </div>
    </div>

</div>
@endsection
