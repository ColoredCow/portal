@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="d-flex justify-content-center row flex-wrap text-center ">
        @can('library_books.view')
        <div class="col-md-3 col-sm-4 card m-3">
            <a class="card-body no-transition" href="/knowledgecafe/library/books">
                <br><h2 class="text-center">Library</h2><br>
            </a>
        </div>
        @endcan
        @can('weeklydoses.view')
        <div class="col-md-3 col-sm-4 card m-3">
            <a class="card-body no-transition" href="/knowledgecafe/weeklydoses/">
            	<br><h2 class="text-center">Weekly Dose</h2><br>
            </a>
        </div>
        @endcan
    </div>
</div>
@endsection
