@extends('layouts.app')

@section('content')

<div class="container" id="home_page">
    @include('status', ['errors' => $errors->all()])
    <br>
    <div class="d-flex justify-content-center row flex-wrap text-center ">
        @can('hr_applicants.view')
        <div class="col-md-3 col-lg-3 col-sm-4 card m-3">
            <a class="card-body no-transition" href="/hr/applications/job">
                <br><h2 class="text-center" style="font-size:2.9vw;">HR</h2><br>
            </a>
        </div>
        @endcan

        @can('finance_reports.view')
        <div class="col-md-3 col-lg-3 col-sm-4 card m-3">
            <a class="card-body no-transition" href="/finance/reports?type=monthly">
                <br><h2 class="text-center" style="font-size:2.9vw;">Finance</h2><br>
            </a>
        </div>
        @endcan

        @if(auth()->user()->can('weeklydoses.view') || auth()->user()->can('library_books.view'))
        <div class="col-md-3 col-lg-3 col-sm-4 card m-3">
            <a class="card-body no-transition" href="/knowledgecafe">
                <br><h2 class="text-center" style="font-size:2.9vw;">Knowledge Cafe</h2><br>

            </a>
        </div>
        @endif
    </div>
</div>

@includeWhen($book, 'knowledgecafe.library.books.show_nudge_modal')

@endsection
