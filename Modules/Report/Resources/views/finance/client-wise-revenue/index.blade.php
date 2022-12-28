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
                        <label><strong>{{ __('Client') }}</strong></label>
                        <select id="clientSelectBox" class="ml-2" name="client_id" onchange="document.getElementById('clientForm').submit();">
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" {{ $client->name == $selectedClient->name ? 'selected' : ''}}>{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <canvas class="w-full" id="clientWiseReportRevenueTrends"></canvas>
            </div>
        </div>
    </div>
    @endsection