@extends('layouts.app')

@section('content')

<div class="container" id="home_page">
    <div class="my-3 my-md-6 my-sm-6">
        <h3>Dashboard</h3>
    </div>

    @if(auth()->user()->getRoleNames()->count() === 0)
        <div class="jumbotron bg-white shadow-sm">
            <h1 class="display-4">Hello, there!</h1>
            <p>Welcome to ColoredCow Portal!</p>
            <hr class="my-4">
            <p>
                It looks like you're brand new here and do not have access to any features! Please contact the administrator to grant you required access so that you can get rolling!
            </p>
        </div>    
    @endif
    
    <div class="mb-2">
        <span>Your FTE: <b class="{{ auth()->user()->ftes['main'] < 1 ? 'text-danger' : 'text-success' }}">{{ auth()->user()->ftes['main'] }}</b></span>
    </div>

    <form method="POST" action="{{ route('storeDropdownValue') }}">
        @csrf
        <div class="dropdown">
            <select class="btn bg-light" name="selectedValue" onchange="this.form.submit()">
                @foreach($centre as $location)
                    <option value="{{ $location->centre_name }}">{{ $location->centre_name }}</option>
                @endforeach
            </select>
        </div>
    </form>
    
    <br>
    
    <div class="card-deck dashboard_view d-flex flex-wrap justify-content-start">
        @can('library_books.view')
            <div class="mr-5 mr-md-3 pr-md-0 pr-4 mb-4 min-w-389">
                <user-dashboard-library />
            </div>
        @endcan

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
            <div class="mb-4 pr-5 min-w-389">
                <user-dashboard-infrastructure />
            </div>
        @endif
    </div>
</div>

@includeWhen($book, 'knowledgecafe.library.books.show_nudge_modal')

@endsection

@section('inline_js')
    new Vue({ el: '#home_page' });
@endsection
