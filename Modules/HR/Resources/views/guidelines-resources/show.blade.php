@extends('hr::layouts.master')
@section('content')
<div class="row col-gap justify-content-center mt-5">
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
                    <th>S. no.</th>
                    <th>Categories</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($resources->first() == null)
        </table>
        <div class="fz-lg-28 text-center mt-2">
            <div class="mb-4">No resources found</div>
        </div>
        @else
        @foreach($resources as $key => $resource)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>
                <a href="{{$resource->resource_link}}">{{ $resource->category->name }}</a>
            </td>
            <td>
                <form action="{{ route('resources.destroy', $resource->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    <a href="#" id="resource_id" resource_id={{ $resource->id }} action_url={{route('resources.update', $resource->id)}} resource_link="{{$resource->resource_link}}" category_id="{{$resource->category->id}}" class="pr-1 btn btn-link rg_edit_btn"><i class="text-success fa fa-edit fa-lg"></i></a>
                    <button type="submit" id="resource_id" class="pl-1 btn btn-link"><i class="text-danger fa fa-trash fa-lg"></i></button>
                </form>
                @includewhen($resource, 'hr::guidelines-resources.edit-modal')
            </td>
            @endforeach
            @endif
            </tbody>
            </table>
    </div>
</div>
@include('hr::guidelines-resources.hr-category-modal')
@include('hr::guidelines-resources.hr-resources-modal')
@endsection
