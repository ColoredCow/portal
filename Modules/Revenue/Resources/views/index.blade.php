@extends('revenue::layouts.master')

@section('content')
    <div class="container" id="revenues">
        @if (session('status'))

        @endif
        <br>
        <div class="d-flex justify-content-between mb-2">
            <h4 class="mb-1 pb-1 fz-28">Revenue</h4>
            <span>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Add Revenue</button>
            </span>
        </div>
        <table class="table table-striped table-bordered">
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Currency</th>
                <th>Amount</th>
                <th>Note</th>
                <th>Date of Recieved</th>
                <th>Action</th>
            </tr>
            @foreach ($revenues as $revenue)
                <tr>
                    <td>{{ $revenue->name }}</td>
                    <td>{{ $revenue->category }}</td>
                    <td>{{ $revenue->currency }}</td>
                    <td>{{ $revenue->amount }}</td>
                    <td>{{ $revenue->notes }}</td>
                    <td>{{ $revenue->recieved_at }}</td>
                    <td>
                        @php
                            $days = $revenue->created_at->diffInDays(today());
                        @endphp
                        @if ($days < 10)
                            <button class="pl-1 btn btn-link" data-toggle="modal" data-target="#modalEdit" data-json="{{$revenue}}"><i class="text-success fa fa-edit fa-lg"></i></button>
                            <a class="pl-1 btn btn-link" id="deleteRevenue" href="{{route('revenue.proceeds.delete',$revenue->id)}}"><i class="text-danger fa fa-trash fa-lg"></i></a>
                        @else
                        <span data-toggle="tooltip" class="ml-7" title="Sorry!! you can't delete it after 10days of creation."><i class="fa fa-question-circle"></i>&nbsp;</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    @include('revenue::edit')
    @include('revenue::create')
@endsection
