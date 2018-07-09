@extends('layouts.app')

@section('content')
<div class="container">
    <br>
   <div class="row d-flex justify-content-start flex-wrap">
        @can('library_books.view')
            <div class="col-md-4">
    <div class="card h-75 mx-4 mt-3 mb-5 ">
            <a class="card-body no-transition" href="/knowledgecafe/library/books">
                <br><h2 class="text-center">Library</h2><br>
            </a>
        </div>
    </div>
        @endcan
        @can('weeklydoses.view')
            <div class="col-md-4">
    <div class="card h-75 mx-4 mt-3 mb-5 ">
            <a class="card-body no-transition" href="/knowledgecafe/weeklydoses/">
            	<br><h2 class="text-center">Weekly Dose</h2><br>
            </a>
        </div>
    </div>
        @endcan
    </div>
</div>
@endsection
