@extends('media::layouts.master')

@section('content')
<div class="container"><br>
    @include('media::media.menu', ['active' => 'media_Tag']) 
    <br>
    <div class="d-flex justify-content-between">
        <div class="text"><h1>Media Tags</h1></div>
        <div><button type="button" class="btn btn-success align-right" data-toggle="modal" data-target="#tagModal"><i class="fa fa-plus mr-1"></i>Add Tags</button></div>
    </div>
    <div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-labelledby="tags" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tags">Add Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="tagForm" action="{{ route('media.Tag.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="tag">Enter Tag</label><strong class="text-danger">*</strong>
                            <input type="text" name="media_tag_name" class="form-control" id="tagName" >
                        </div><br>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr class="sticky-top">
            <th>{{ __('tags') }}</th>
            <th>{{ __('Edit') }}</th>
            <th>{{ __('Delete') }}</th>
        </tr>
        @foreach ($tags as $tag)
        <tr>
            <td>
                <span class="d-flex text-justify-center">
                {{$tag->media_tag_name}}
                </span>
            </td>
            <td>
             <button type="button" class="pr-1 btn btn-link" data-toggle="modal" data-target="#designationEditFormModal" data-json="{{$tag}}" ><i class="text-success fa fa-edit fa-lg"></i></button>
            </td>
            <td>
                <form action="{{ route('media.Tag.destroy', ['id' => $tag->id]) }}" method="post">
                    @csrf
                    <button type="submit" class="pl-1 btn btn-link" onclick="return confirm('Are you sure you want to delete?')"><i class="text-danger fa fa-trash fa-lg"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection