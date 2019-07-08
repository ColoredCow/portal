@extends('layouts.app') 
@section('content')
<div class="container"  id="show_book_info"  data-book="{{ json_encode($book) }}"  
    data-is-read="{{ $book->readers->contains(auth()->user()) }}" data-is-borrowed="{{ $book->borrowers->contains(auth()->user()) }}"
    data-mark-book-route= "{{ route('books.toggleReadStatus') }}" data-borrow-book-route= "{{ route('books.markAsBorrowed', $book->id) }}" 
    data-put-back-book-route= "{{ route('books.putBack', $book->id) }}"  data-readers = "{{ json_encode($book->readers) }}"
    data-borrowers = "{{ json_encode($book->borrowers) }}">

    <div class="card mx-5">
        <div class="card-body">
            <h1 class="mt-1 mb-4 mx-2">
                {{ $book->title }}
            </h1>

            <div class="row">

                <div class="col-md-3 col-xs-12 pl-4 text-left">
                    <img src=" {{ $book->thumbnail }} " />
                </div>

                <div class="col-md-4 col-xs-12">

                    <div class="ml-1 mb-1 d-flex">
                        <h4>Authors:</h4>
                        <span class="pl-5"> {{ $book->author }} </span>
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

                    <div class="ml-1 mb-1 mt-2 d-flex justify-content-between">
                        <span>
                            <button class="btn btn-info p-2" @click="borrowTheBook()" v-if="!isBorrowed">I have this book</button>
                            <button class="btn btn-success p-2" @click="putTheBookBackToLibrary()" v-else>I have returned it</button>
                        </span>

                        <span>
                            <button class="btn btn-primary p-2" @click="markBook(true)" v-if="!isRead">I have read this book</button>
                            <button class="btn btn-danger p-2" @click="markBook(false)" v-else>Mark as unread</button>
                        </span>

                    </div>

                </div>
            </div>

            <div class="row mt-4" id="readers_section" >
                <div class="col-4">
                    <div class="ml-1 mb-1 mt-2 w-100">
                        <h5 class="font-italic text-bold" v-if="borrowers.length">Borrowed by:</h5>
                        <div class="d-flex justify-content-start"> 
                            <div v-for="(borrower, index)  in borrowers " class="mt-2 mr-2 text-center">
                                <img :src="borrower.avatar" alt="" class="reader_image">
                                <h6 class="pt-2"> @{{ borrower.name }} </h6>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="ml-1 mb-1 mt-2 w-100">
                        <h5 class="font-italic text-bold"  v-if="readers.length">Read by:</h5>
                        <div class="d-flex justify-content-start"> 
                            <div v-for="(reader, index)  in readers " class="mt-2 mr-2 text-center">
                                <img :src="reader.avatar" alt="" class="reader_image">
                                <h6 class="pt-2"> @{{ reader.name }} </h6>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <books-comments-component 
            new_comment_route = "{!! route('book-comment.store', $book->id) !!}"
            :book = "{{ json_encode($book) }}"
       
            />
    </div>
</div>


@endsection