@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Weekly Doses</h1>
    <br><br>
    <table class="table table-striped table-bordered" id="table_weeklydoses">
        <tr>
            <th>Description</th>
            <th>URL</th>
            <th>Recommended By</th>
            <th>Date</th>
        </tr>
        @foreach ($weeklydoses as $weeklydose)
        <tr>
            <td>{{ $weeklydose->description }}</td>
            <td><a href="{{ $weeklydose->url }}" target="_blank">{{ $weeklydose->url }}</a></td>
            <td>{{ $weeklydose->recommended_by }}</td>
            <td>{{ date_format($weeklydose->created_at, 'Y-m-d') }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
