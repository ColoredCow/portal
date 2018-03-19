@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Job title</th>
            <th>Total applicants</th>
            <th>Accepted</th>
            <th>Rejected</th>
            <th>In Progress</th>
        </tr>
        @foreach ($jobs as $job)
        <tr>
            <td><a href="{{ $job->link }}" target="_blank">{{ $job->title }}</a></td>
            <td>13</td>
            <td>9</td>
            <td>2</td>
            <td>2</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
