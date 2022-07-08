@extends('hr::layouts.master')
@section('content')
<div class="row col-gap justify-content-center">
    <div class="col-md-7">
        <h3>Resources for Laravel Developer</h3>
    </div>
    <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-toggle="modal" data-bs-target="#create-Modal"><i class="fa fa-plus"></i>
        {{ __('Add Resources') }}
        </button>
    </div>
    <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-block btn-lg" data-bs-toggle="modal" data-bs-target="#createModal"><i class="fa fa-plus"></i>
        {{ __('Add category') }}
        </button>
    </div>
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
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                        <a href="#">{{ $category->name }}</a>  
                    </td>
                    <td>
                        <a class="pr-1 btn btn-link" href="#"><i class="text-success fa fa-edit fa-lg"></i></a>
                        <button type="submit" class="pl-1 btn btn-link"><i class="text-danger fa fa-trash fa-lg"></i></button>
                    </td>
            @endforeach
        </tbody>
    </table>
</div>
@include('hr::guidelines-resources.create-category-modal')
@include('hr::guidelines-resources.create-resources-modal')
@endsection
