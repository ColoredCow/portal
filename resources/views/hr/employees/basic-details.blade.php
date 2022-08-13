@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.employees.sub-views.menu', $employee)
    <br><br>
    <div class= "card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
               <div class="d-flex">
                  <div class="d-flex flex-column bd-highlight mb-3">
                        <div class="form-group">
                            <label class="font-weight-bold" for="">Name:</label>
                            <span>{{ $employee->name }}</span>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="">Email:</label>
                            <span>{{ $employee->email }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-info">Edit</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

