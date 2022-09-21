@extends('layouts.app')
@section('content')

<div class="container">
    <div class="text-primary">
        <h1><b> Requisition Dashbord</b></h1>
    </div><br>
    @include('hr.requisition.menu')<br>
    <div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="batchMembersModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="batchMembersModalLabel">Batch Members Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- @dd($member) --}}
                    <form id="batchDetailsForm" action="{{ route('requisition.storeBatchDetails') }}" method="post">
                        @csrf
                        <input type="text" id="batchId" name="batchId" value="{{$member->id}}">
                        <label for="teamMembersDropdown">Select Team Members</label>
                        <select class="form-control"  name="teamMembers[]" multiple="multiple">
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select><br>
                        <div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="spinner-border text-primary d-none" id="spinner"></div>
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
                <input class="check-input status" type="checkbox" data-id="{{ $requisition->id }}">
                <label>Mark as Complete</label>
            </td>
        </tr>
        @endforeach
    </table>
</div>    
@endsection
