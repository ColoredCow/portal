@extends('layouts.app')

@section('content')

<div class="container" id="home_page">
    @include('status', ['errors' => $errors->all()])
    <br>

    <div class="d-flex justify-content-start row flex-wrap">
        @if(auth()->user()->hasAnyPermission(['hr_recruitment_applications.view', 'hr_employees.view', 'hr_volunteers_applications.view']))
        <div class="col-md-3 card m-3">
            <a class="card-body no-transition" href="/hr">
                <br><h2 class="text-center">HR</h2><br>
            </a>
        </div>
        @endif

        @can('finance_reports.view')
        <div class="col-md-3 card m-3">
            <a class="card-body no-transition" href="/finance/reports?type=monthly">
                <br><h2 class="text-center">Finance</h2><br>
            </a>
        </div>
        @endcan

         @if(auth()->user()->hasAnyPermission(['crm_talent.view', 'crm_client.view']))
        <div class="col-md-3 card m-3">
            <a class="card-body no-transition" href="{{ route('crm') }}">
                <br><h2 class="text-center">CRM</h2><br>
            </a>
        </div>
        @endif

        @if(auth()->user()->hasAnyPermission(['weeklydoses.view', 'library_books.view']))
        <div class="col-md-3 card m-3">
            <a class="card-body no-transition" href="/knowledgecafe">
                <br><h2 class="text-center">KnowledgeCafe</h2><br>
            </a>
        </div>
        @endif
    </div>
</div>

@includeWhen($book, 'knowledgecafe.library.books.show_nudge_modal')

@endsection
