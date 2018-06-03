@extends('layouts.app') 
@section('content')
<div class="container" id="show_book_info"  data-book="{{ json_encode($book) }}" >
    <div class="card">
        <div class="card-body">

            <h1 class="mt-1 mb-4 mx-2">
                {{ $book->title }}
            </h1>

            <div class="row">
                <div class="col-4">
                    <div class="ml-1 mb-1 d-flex justify-content-between">
                        <h4>Authors:</h4>
                        <span> {{ $book->author }} </span>
                    </div>

                    <div class="ml-1 mb-1 d-flex justify-content-between">
                        <h4>Category:</h4>
                        <div>  
                            <ul class="pl-3">
                                @foreach(($book->categories) ?: [] as $category)
                                    <li> {{$category->name}} </li>
                                @endforeach
                            </ul> 
                        </div>
                    </div>

                    <div class="ml-1 mb-1 d-flex justify-content-between">
                        <h4>ISBN :</h4>
                        <span> {{ $book->isbn }} </span>
                    </div>
                </div>

                <div class="col-4 text-center">
                    <img src=" {{ $book->thumbnail }} " />
                </div>

                <div class="col-4 text-center">
                       <button class="btn btn-primary">I have read this book</button>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection