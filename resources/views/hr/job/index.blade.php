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
        <tr>
            <td><a href="#" target="_blank">Laravel Developer</a></td>
            <td>13</td>
            <td>9</td>
            <td>2</td>
            <td>2</td>
        </tr>
        <tr>
            <td><a href="#" target="_blank">DevOps Engineer</a></td>
            <td>13</td>
            <td>9</td>
            <td>2</td>
            <td>2</td>
        </tr>
        <tr>
            <td><a href="#" target="_blank">Marketing</a></td>
            <td>13</td>
            <td>9</td>
            <td>2</td>
            <td>2</td>
        </tr>
    </table>
</div>
@endsection
