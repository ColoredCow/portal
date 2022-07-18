@extends('salary::layouts.master')
@section('content')
<div class="container">
    <br>
        @include('hr.employees.sub-views.menu')
    <br>
    <div class="mt-4 card">
        <div class="card-header pb-lg-5 fz-28">
            <div class="mt-4 ml-5">Employee Salary</div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mx-5 align-items-end">
            <div>    
                <h1>Abhishek Khanduri</h1>
    {{--        <h1>{{$employee->name}}</h1>
                @if(optional($employee->user()->withTrashed())->first()->avatar)
                    <img src="{{ $employee->user()->withTrashed()->first()->avatar }}" class="w-100 h-100 rounded-circle">
                @endif
            </div>  --}}
                <hr class='bg-dark mx-4 pb-0.5'>
                <br>
                <br>
                <input type="number" step="0.01" name="grossSalary" class="form-control" id="grossSalary" placeholder="Enter Gross Salary" value={{request()->get('salary')}}>
            </diV> 
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>    
</div>
@endsection