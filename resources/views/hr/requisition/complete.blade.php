@extends('layouts.app')

@section('content')

<div class="container">
    <div class="text-primary">
        <h1><b> Requisition Dashbord</b></h1>
    </div><br>
    @include('hr.requisition.menu')<br>
    <div class="spinner-border text-primary d-none" id="completeSpinner"></div>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr class="sticky-top">
            <th>Domain</th>
            <th>Job Title</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        @foreach ($requisitions as $requisition)
        <tr>
            <td>
                {{ $requisition->hrJobDomain->domain}}
            </td>
            <td>
                {{$requisition->job->title}}     
                    
            </td>
            <td>
                <span {{ $requisition->id }}>{{$requisition->created_at}}</span>
            </td>
            <td>
                <input class="check-input pending"  id="checked" type="checkbox" data-id="{{ $requisition->id }}" checked>
                <label>Unmark to Pending</label>
            </td>
        </tr>
        @endforeach
    </table>
</div>    
@endsection
