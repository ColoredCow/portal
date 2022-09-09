@extends('expense::layouts.master')
@section('content')
    <div class="container" id="revenues">
        <br />
        <div class="d-flex justify-content-between mb-2">
            <h4 class="mb-1 pb-1 fz-28">Revenue</h4>
            <span>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-revenue">Add Revenue</button>
            </span>
        </div>
        <table class="table table-striped table-bordered">
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Currncy</th>
                <th>Amount</th>
                <th>Note</th>
                <th>Date of Recieved</th>
                <th>action</th>
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
                        <button type="button" value="{{$revenue->id}}" class="btn btn-primary" data-toggle="modal" data-target="#edit-revenue">Edit</button>  
                        <a href="{{ route('revenue.delete', ['id' =>$revenue->id]) }}" class="btn btn-red text-white">delete</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    @include('revenue::edit')
    @include('revenue::create')
@endsection

@section('script')
