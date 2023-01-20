@extends('hr::layouts.master')
@section('content')
<div class="container ">
    <div class="row col-gap justify-content-center mt-5">
        <div class="col-md-6">
            <h3> Resources & Guidelines</h3>
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
                        <th class="text-center">Categories</th>
                        <th class="text-center">Read by</th>
                        <th class="text-center">Users Suggestions</th>
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
            <tr class="resource-tr">
                <td class="text-center">
                    <div class="row justify-content-center ">
                        <div class="col-md-5 ">
                            <a href="{{$resource->resource_link}}">{{ $resource->category->name }}</a>
                        </div>
                        <div class="col-md-5 col-md-offset-2">
                            <form action="{{ route('resources.destroy', $resource->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                <a href="#" data-toggle="modal" data-target="#edit-Modal" id="resource_id" resource_id={{ $resource->id }} action_url={{route('resources.update', $resource->id)}} resource_link="{{$resource->resource_link}}" category_id="{{$resource->category->id}}" class="pr-1 btn btn-link rg_edit_btn"><i class="text-success fa fa-edit fa-lg"></i></a>
                                <button type="submit" id="resource_id" data-toggle="modal" class="pl-1 btn btn-link"><i class="text-danger fa fa-trash fa-lg"></i></button>
                            </form>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    @foreach ($usersResourcesAndGuidelines as $usersResourceAndGuideline)
                        @if (!$usersResourceAndGuideline->mark_as_read && $usersResourceAndGuideline->category==$resource->category->name)
                            <span class="content tooltip-wrapper" title="{{ $usersResourceAndGuideline->employee->user->name }}">
                            <img src="{{ $usersResourceAndGuideline->employee->user->avatar }}" data-url="{{ route('resources.index.id',[$usersResourceAndGuideline->id]) }}" class="w-35 resource-avatar h-30 rounded-circle mb-1 mr-0.5 {{ $usersResourceAndGuideline->employee->user->border_color_class }} border-2"></span>
                        @endif
                    @endforeach
                </td>
                <td class="response-data text-center">
                    <span class="content tooltip-wrapper">
                        <img class="w-35 h-30 rounded-circle mb-1 mr-0.5 border-2"></span></br>
                    <p class="response text-primary">&larr; please click on avatar</p>
                </td>
            </tr>
            @includewhen($resource, 'hr::guidelines-resources.edit-modal')
            @endforeach
            @endif
            </tbody>
            </table>
        </div>
    </div>
    @include('hr::guidelines-resources.hr-category-modal')
    @include('hr::guidelines-resources.hr-resources-modal')
</div>
@endsection
