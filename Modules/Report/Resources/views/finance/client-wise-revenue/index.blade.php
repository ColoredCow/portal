@extends('report::layouts.finance')
@section('content')
    <div class="container" id="vueContainer">
        <div>
            <div class="mt-4 container">
                <h3>
                    Client Wise Revenue
                </h3>
                <div class="mt-4"> 
                    <form id="clientForm" action="{{ route('reports.finance.dashboard.client') }}">
                        <div>
                            <label><strong>{{ __('Client') }}</strong></label>
                            <select id="clientSelectBox" class="ml-2 w-320" name="client_id" onchange="document.getElementById('clientForm').submit();">
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" {{ $client->name == $selectedClient->name ? 'selected' : ''}}>{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex mt-3">
                            <div>
                                <label><strong>{{ __('Start date') }}</strong></label>
                                <input type="date" id="startDate" name="start_date" value="{{ request()->get('start_date') }}">
                            </div>
                            <div class="ml-3">
                                <label><strong>{{ __('End date') }}</strong></label>
                                <input type="date" id="endDate" name="end_date" value="{{ request()->get('end_date') }}">
                            </div>
                        </div>
                        <input class="mt-3" type="submit" value="Apply filters">
                    </form>
                </div>
                <canvas class="w-full" id="clientWiseReportRevenueTrends"></canvas>
            </div>
        </div>
    </div>
    @endsection