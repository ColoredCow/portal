@extends('operations::layouts.master')
@section('content')
<div class="container">
    <div class="col-lg-12 d-flex justify-content-between align-items-center mx-auto">
        <div>
            <h1>@yield('heading')</h1>
        </div>
        <div>
            @include('operations::modals.operation')
        </div>
    </div>
        <div>
            <br>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr class="text-center sticky-top">
                        <th class="col-md-4">Centre Name</th>
                        <th class="col-md-2">Centre Head</th>
                        <th>Capacity</th>
                        <th>Current People Count</th>
                    </tr>
                </thead>
                <tbody>
                    <td>No Data Avaialable</td>
                </tbody>
            </table>
        </div>
</div>
@endsection
