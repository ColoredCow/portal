@extends('operations::layouts.master')

@section('heading')

@section('content')
<div class="container">
    <div>
        @include('operations::modals.operation')
    </div>
    <br><br>
    <div>
        <br>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr class="text-center sticky-top">
                    <th class="col-md-4">Centre Name</th>
                    <th class="col-md-2">Centre Head</th>
                    <th>Capacity</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
