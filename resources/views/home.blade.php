@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="d-flex justify-content-start row flex-wrap">
        @can('hr_applicants.view')
        <div class="col-md-3 card mx-5 my-3">
            <a class="card-body no-transition" href="/hr/applications/job">
                <br><h2 class="text-center">HR</h2><br>
            </a>
        </div>
        @endcan
        @can('finance_reports.view')
        <div class="col-md-3 card mx-5 my-3">
            <a class="card-body no-transition" href="/finance/reports?type=monthly">
                <br><h2 class="text-center">Finance</h2><br>
            </a>
        </div>
        @endcan
        @can('weeklydoses.view')
        <div class="col-md-3 card mx-5 my-3">
            <a class="card-body no-transition" href="/weeklydoses/">
                <br><h2 class="text-center">WeeklyDose</h2><br>
            </a>
        </div>
        @endcan
        @can('library_books.view')
        <div class="col-md-3 card mx-5 my-3">
            <a class="card-body no-transition" href="/knowledgecafe">
                <br><h2 class="text-center">Knowledge Cafe</h2><br>
            </a>
        </div>
        @endcan
    </div>

</div>
@endsection
