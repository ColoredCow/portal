@extends('operations::layouts.master')

@section('heading')
@section('content')
<div class="container">
      <div >
        <div>
            @include('operations::modals.operation')
        </div>
    </div>
    <br><br>
    </ul>
        <div>
            <br>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <thead class="thead-dark">
                        <tr class="text-center sticky-top">
                            <th class="col-md-4">Center Name</th>
                            <th class="col-md-2">Center Head</th>
                            <th>Capacity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
            </table>
        </div>
    </div>
    @endsection