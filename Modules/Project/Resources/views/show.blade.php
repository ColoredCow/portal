@extends('project::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    <br> <h4 clss="c-pointer" class="d-inline-block" v-on:click="counter += 1">{{ $project->name }}</h4>
    <a  id="view_effort_sheet_badge" target="_self" href= "{{route('project.edit', $project )}}" class="btn btn-info text-white ml-2">{{ _('Edit') }}</a>

    <div class="mt-3">
        @include('status', ['errors' => $errors->all()])
        <div class="card">
            <form action="{{ route('project.store') }}" method="POST" id="form_project">
                @csrf 
                <div class="card-header">
                    <span>Project Details</span>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection