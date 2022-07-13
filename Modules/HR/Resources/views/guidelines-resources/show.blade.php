@extends('hr::layouts.master')
@section('content')
<div class="row col-gap justify-content-center">
    <div class="col-md-6">
        <h3>Resources for {{$job->title}}</h3>
    </div>
    <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-block btn-lg" data-toggle="modal" data-target="#create-Modal"><i class="fa fa-plus"></i>
            {{ __('Add Resources') }}
        </button>
    </div>
    <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-block btn-lg" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i>
            {{ __('Add category') }}
    </div>
<div class="container mx-15 mt-5">
    <table class="table table-bordered table-striped">
        <thead class="thead-primary">
            <tr>
                <th>Sno</th>
                <th>Categories</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($resources->first() == null)
    </table>
    <div class="fz-lg-28 text-center mt-2">
        <div class="mb-4">Not in any resources</div>
    </div>
    @else
    @foreach($resources as $key => $resource)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>
            <a href="{{$resource->resource_link}}">{{ $resource->category->name }}</a>
        </td>
        <td>
            <a class="pr-1 btn btn-link" href="#"><i class="text-success fa fa-edit fa-lg"></i></a>
            <button type="submit" class="pl-1 btn btn-link"><i class="text-danger fa fa-trash fa-lg"></i></button>
        </td>
        @endforeach
        @endif
        </tbody>
        </table>
</div>
@include('hr::guidelines-resources.create-category-modal')
@include('hr::guidelines-resources.create-resources-modal')
@endsection
