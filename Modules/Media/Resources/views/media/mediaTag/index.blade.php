@extends('media::layouts.master')

@section('content')
<div class="container" id="media_tag">
    <br>
    @include('media::media.menu', ['active' => 'media_tag']) 
    <br>
    <br>
    <div class="row">
        <div class="col-md-6"><h1>Media Tags</h1></div>
        <div class="col-md-6">
            {{-- <button @click="updateNewTagMode('add')" class="btn btn-success float-right">Add Tags</button> --}}
        </div>
    </div>

    <div class="row mt-3 mb-2">
        <div class="col-12">
            {{-- <h4 class="font-weight-bold"><span>@{{ tags.length }}</span>&nbsp;Tags</h4> --}}
        </div>
    </div>

    <div id="tag_container" 
        {{-- data-tags="{{ json_encode($tags) }}" --}}
        {{-- data-index-route="{{ route('mediaTag.index') }}"  --}}
        class ="table-bordered">

        <div class="row py-3 border-bottom mx-0" v-if="newTagMode == 'add'">
            <div class="col-lg-8 d-flex justify-content-between">
                <input class="form-control mr-3" v-model="newTagName" type="text" placeholder="Enter Tag Name" autofocus>
                {{-- <button type="button" class="btn btn-info px-3 mr-2" @click="addNewTag()" >Add</button> --}}
                {{-- <button type="button" class="btn btn-secondary px-3" @click="updateNewTagMode('cancel')" >Cancel</button> --}}
            </div>
        </div>

        <div v-for="(tag, index) in tags" class="row py-3 border-bottom mx-0">
            <div class="col-lg-4">
                <span v-if="tag.editMode">
                    <div class="d-flex justify-content-between">
                        <input class="form-control mr-3" type="text" v-model="tagNameToChange[index]">
                        {{-- <button type="button" class="btn btn-success btn-sm" @click="updateTagName(index)">Save</button> --}}
                    </div>
                </span>

                <span v-else >
                    {{-- @{{ tag.name }} --}}
                </span>

            </div>

            <div class="col-lg-4">
                <span v-if = "!tag.assign_media_count">No media for this tag</span> 
                <span v-else>
                    {{-- <span> @{{ tag.assign_media_count }}</span>  --}}
                    {{-- <span> @{{ (tag.assign_media_count > 1) ? 'media' : 'media' }} </span> --}}
                </span>
            </div>

            <div class="col-lg-4 d-flex align-items-center justify-content-end">
                {{-- <div @click="showEditMode(index)"> --}}
                   <button class="btn btn-primary">
                    <i class="fa fa-pencil"></i>&nbsp;Edit
                   </button>
                </div>
                
                {{-- <div class="text-danger c-pointer ml-3" @click="deleteTag(index)"> --}}
                    <i class="fa fa-times"></i>&nbsp;Delete
                </div>
            </div>

        </div>
    </div>
</div>


@endsection