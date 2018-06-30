@extends('layouts.app')

@section('content')

<div class="container" id="home_page">
    @include('status', ['errors' => $errors->all()])
    <br>

    <div class="d-flex justify-content-start row flex-wrap">
        @if(auth()->user()->can('hr_recruitment.view') || auth()->user()->can('hr_employees.view') || auth()->user()->can('hr_volunteers.view'))
        <div class="col-md-3 card mx-5 mt-3 mb-5">
            <a class="card-body no-transition" href="/hr">
                <br><h2 class="text-center">HR</h2><br>
            </a>
        </div>
        @endif

        @can('finance_reports.view')
        <div class="col-md-3 card mx-5 mt-3 mb-5">
            <a class="card-body no-transition" href="/finance/reports?type=monthly">
                <br><h2 class="text-center">Finance</h2><br>
            </a>
        </div>
        @endcan

        @if(auth()->user()->can('weeklydoses.view') || auth()->user()->can('library_books.view'))
        <div class="col-md-3 card mx-5 mt-3 mb-5">
            <a class="card-body no-transition" href="/knowledgecafe">
                <br><h2 class="text-center">KnowledgeCafe</h2><br>
            </a>
        </div>
        @endif

        @if(auth()->user()->can('crm_talent.view') || auth()->user()->can('crm_client.view'))
        <div class="col-md-3 card mx-5 mt-3 mb-5">
            <a class="card-body no-transition" href="{{ route('crm') }}">
                <br><h2 class="text-center">CRM</h2><br>
            </a>
        </div>
        @endif
    </div>
</div>

@includeWhen($book, 'knowledgecafe.library.books.show_nudge_modal')

@endsection
