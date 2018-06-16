@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="d-flex justify-content-center row flex-wrap text-center ">
        @can('library_books.view')
        <div class="col-md-3 card mx-5 my-3">
            <a class="card-body no-transition" href="/knowledgecafe/library/books">
                <br><h2 class="text-center" style="font-size:2.9vw;">Library</h2><br>
            </a>
        </div>
        @endcan
        @can('weeklydoses.view')
        <div class="col-md-3 card mx-5 my-3">
            <a class="card-body no-transition" href="/knowledgecafe/weeklydoses/">
            	<br><h2 class="text-center" style="font-size:2.9vw;">Weekly Dose</h2><br>
            </a>
        </div>
        @endcan
    </div>
</div>
@endsection
