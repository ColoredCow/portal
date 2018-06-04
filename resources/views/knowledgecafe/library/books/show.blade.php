@extends('layouts.app') 
@section('content')
<div class="container" id="show_book_info"  
    data-book="{{ json_encode($book) }}" 
    data-mark-book-route= {{route('books.markBook')}}
    data-is-read = {{ $book->readers->contains(auth()->user()) }}
    >
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

                    <div class="ml-1 mb-1 mt-5 d-flex justify-content-between">
                            <button class="btn btn-primary p-2" @click="markBook(true)" v-if="!isRead">I have read this book</button>
                            <button class="btn btn-danger p-2" @click="markBook(false)" v-else>Mark as unread</button>
                    </div>

                </div>

                <div class="col-4 text-center">
                    <img src=" {{ $book->thumbnail }} " />
                </div>


            </div>

        </div>
    </div>
</div>
@endsection