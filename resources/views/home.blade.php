@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="d-flex justify-content-between row">
        @can('view.hr_applicants')
        <div class="col-md-3 card">
            <a class="card-body no-transition" href="/hr/applicants/">
                <br><h2 class="text-center">HR</h2><br>
            </a>
        </div>
        @endcan
        @can('view.finance_reports')
        <div class="col-md-3 card">
            <a class="card-body no-transition" href="/finance/reports?show=default">
                <br><h2 class="text-center">Finance</h2><br>
            </a>
        </div>
        @endcan
        @can('view.weeklydoses')
        <div class="col-md-3 card">
            <a class="card-body no-transition" href="/weeklydoses/">
                <br><h2 class="text-center">WeeklyDose</h2><br>
            </a>
        </div>
        @endcan
    </div>

    <br>

    <div class="d-flex justify-content-between row">
        @can('view.library_books')
        <div class="col-md-3 card">
            <a class="card-body no-transition" href="/knowledgecafe">
                <br><h2 class="text-center">Knowledge Cafe</h2><br>
            </a>
        </div>
        @endcan
    </div>

</div>
@endsection
