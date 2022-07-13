@extends('layouts.app')

@section('content')

<div class="container" id="home_page">
    <div class="m-3 m-md-6 m-sm-6">
        <h3>Dashboard</h3>
    </div>

    <div class=" card-deck dashboard_view d-flex flex-wrap justify-content-start ml-3">

        @if(auth()->user()->canAny(['weeklydoses.view', 'library_books.view']))
        <div class="mr-5 mr-md-3 pr-md-0 pr-4 mb-4 min-w-389">
            <user-dashboard-library />
        </div>
        @endif

        @can('projects.view')
        <div class="pr-5 mb-4 min-w-389">
            <user-dashboard-projects />
        </div>
        @endcan

        @if(Module::checkStatus('Invoice') && auth()->user()->can('invoice.view'))
        <div class="mr-5 mr-md-3 pr-md-0 pr-4 mb-4 min-w-389">
            <user-dashboard-invoice />
        </div>
        @endif

        @if(Module::checkStatus('Infrastructure') && auth()->user()->can('infrastructure.billings.view'))
        <div class=" mb-4 pr-5 min-w-389">
            <user-dashboard-infrastructure />
        </div>
        @endif

    </div>
</div>
@includeWhen($book, 'knowledgecafe.library.books.show_nudge_modal')

@endsection

@section('inline_js')
new Vue({ el: '#home_page'});
@endsection
