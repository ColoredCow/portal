@extends('layouts.app')

@section('content')

<div class="container" id="home_page">
    @include('status', ['errors' => $errors->all()])
    <br>

    <div class="d-flex justify-content-between row flex-wrap">
        <div class="card col-md-3 m-3 px-2">
            <a class="card-body no-transition" href="/hr">
                <br><h2 class="text-center">HR</h2><br>
            </a>
        </div>

        @can('finance_reports.view')
        <div class="card col-md-3 m-3 px-2">
            <a class="card-body no-transition" href="/finance/reports?type=monthly">
                <br><h2 class="text-center">Finance</h2><br>
            </a>
        </div>
        @endcan

        @if(auth()->user()->can('weeklydoses.view') || auth()->user()->can('library_books.view'))
        <div class="card col-md-3 m-3 px-2">
            <a class="card-body no-transition" href="/knowledgecafe">
                <br><h2 class="text-center">KnowledgeCafe</h2><br>
            </a>
        </div>
        @endif

        <div class="card col-md-3 m-3 px-2">
            <a class="card-body no-transition" href="{{ route('crm') }}">
                <br><h2 class="text-center">CRM</h2><br>
            </a>
        </div>
    </div>
</div>

@includeWhen($book, 'knowledgecafe.library.books.show_nudge_modal')

@endsection
