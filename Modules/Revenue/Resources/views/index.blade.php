@extends('revenue::layouts.master')

@section('content')
    <div class="container" id="revenue_proceeds">
        @if (session('status'))

        @endif
        <br>
        <div class="d-flex justify-content-between mb-2">
            <h4 class="mb-1 pb-1 fz-28">Revenue Proceeds</h4>
            <span>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModal">Add Revenue</button>
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
            @foreach ($revenueProceeds as $revenueProceed)
                <tr>
                    <td>{{ $revenueProceed->name }}</td>
                    <td>{{Str::title(str_replace('-', ' ', $revenueProceed->category))}}</td>
                    <td>{{ $revenueProceed->currency }}</td>
                    <td>{{ $revenueProceed->amount }}</td>
                    <td>{{ $revenueProceed->notes }}</td>
                    <td>{{ $revenueProceed->recieved_at }}</td>
                    <td>
                        @php
                            $days = $revenueProceed->created_at->diffInDays(today());
                        @endphp
                        @if ($days < 10)
                            <button class="pl-1 btn btn-link" data-toggle="modal" data-target="#modalEdit" data-json="{{$revenueProceed}}"><i class="text-success fa fa-edit fa-lg"></i></button>
                            <a class="pl-1 btn btn-link" id="deleteRevenue" href="{{route('revenue.proceeds.delete',$revenueProceed->id)}}"><i class="text-danger fa fa-trash fa-lg"></i></a>
                        @else
                        <span data-toggle="tooltip" class="ml-7" title="Sorry!! you can't Edit or Delete it after 10days of creation."><i class="fa fa-question-circle"></i>&nbsp;</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    @include('revenue::revenue-proceeds.edit')
    @include('revenue::revenue-proceeds.create')
@endsection
