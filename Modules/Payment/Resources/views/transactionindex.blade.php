@extends('payment::layouts.master')
@section('content')
@php
    $time=now()->timestamp;
@endphp
@if(request()->source)
@dd(request()->all())
@endif
<div class="card">
    @include('payment::menu_header')
    <div class="card-header">
    </div>
    <div class="card-body">
        <div id="expense_form">
            <form action="#">
                @csrf
                <input type="hidden" value="expense_details" name="transaction_section">
                <div class="mx-5">
                    <table class="table table-body">
                        <thead>
                            <tr class="bg-theme-gray text-light">
                                <th scope="col" class="pb-lg-4"><div class="ml-7">Source</div></th>
                                <th scope="col" class="pb-lg-4"><div class="ml-7">Category</th>
                                <th scope="col" class= "pb-lg-4"><div class="ml-7">Value</th>
                                <th scope="col" class="pb-lg-4"><div class="ml-7">Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="col"><input type="textarea" class="form-control" name="source[{{$time}}][source]"></td>
                                <td scope="col"><input type="textarea" class="form-control" name="source[{{$time}}][{{$time}}][category]"></td>
                                <td scope="col"><input type="textarea" class="form-control" name="source[{{$time}}][{{$time}}][value]"></td>
                                <td scope="col"><input type="textarea" class="form-control" name="source[{{$time}}][{{$time}}][comment]"></td>
                            </tr>
                            <tr>
                                <td><div type="button" class="btn btn-primary add-source" name="{{$time}}"><i class="fa fa-plus" aria-hidden="true"></i></div></td>
                                <td><div type="button" class="btn btn-primary add-category" data-value="{{$time}}" name="{{$time}}"><i class="fa fa-plus" aria-hidden="true"></i></div></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>  
                </div>
                <div class="card-footer">
                    <input type="submit"class="btn btn-primary ml-5">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
