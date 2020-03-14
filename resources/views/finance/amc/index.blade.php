@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'amc'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>AMC</h1></div>
        <div class="col-md-6"><a href="{{ route('amc.create') }}" class="btn btn-success float-right">Setup New AMC</a></div>
    </div>
    <form action="/finance/amc" method="GET" class="form-inline mt-4 mb-4 d-flex justify-content-end">
        <div class="form-group">
            <input type="date" name="start" id="start" placeholder="dd/mm/yyyy" class="form-control form-control-sm" value="{{ $startDate ?? '' }}">
        </div>
        <div class="form-group ml-2">
            <input type="date" name="end" id="end" placeholder="dd/mm/yyyy" class="form-control form-control-sm" value="{{ $endDate ?? '' }}">
        </div>
        <div class="form-group ml-2">
            <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
        </div>
    </form>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Project</th>
            <th>Cycly</th>
            <th>Started at</th>
            <th>Max alloted hours</th>
            <th>Effort</th>
        </tr>
        @foreach ($amcs ?? [] as $amc)
        <tr>
            <td>{{ $amc->project->name }}</td>
            <td>{{ \Str::title($amc->payment_cycle) }}</td>
            <td>{{ $amc->started_at }}</td>
            <td>{{ $amc->alloted_hours }}</td>
            <td><a target="_blank" href="{{$amc->effort_sheet_link}}">Effort sheet link </a></td>
        </tr>
        @endforeach
    </table>

</div>
@endsection
