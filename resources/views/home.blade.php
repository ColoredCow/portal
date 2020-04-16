@extends('layouts.app')

@section('content')

<div class="container" id="home_page">
    <div>
        @include('dashboard.modules')
    </div>

    <div class="m-3 ">
        <h3>Dashboard</h3>
    </div>



    <div class="dashboard_view d-flex  flex-wrap justify-content-start ml-3">

        @if(auth()->user()->hasAnyPermission(['weeklydoses.view', 'library_books.view']))
        <div style="width: 25rem;" class="mr-5 mb-4">
            <user-dashboard-library />
        </div>
        @endif


        <div style="width: 25rem;">
            <user-dashboard-projects />
        </div>
        
    </div>

    <div>

    </div>
    
</div>


@includeWhen($book, 'knowledgecafe.library.books.show_nudge_modal')

@endsection


@section('inline_js')
new Vue({ el: '#home_page'});
@endsection