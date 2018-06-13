@extends('layouts.app') 
@section('content')
<div class="container" id="show_book_info"  
  
    data-book="{{ json_encode($book) }}" 
    data-is-read="{{ $book->readers->contains(auth()->user()) }}"
    data-mark-book-route= "{{route('books.toggleReadStatus')}}"
    data-readers = "{{ json_encode($book->readers) }}"

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

                    <div class="ml-1 mb-1 mt-5 d-flex justify-content-between">
                            <button class="btn btn-primary p-2" @click="markBook(true)" v-if="!isRead">I have read this book</button>
                            <button class="btn btn-danger p-2" @click="markBook(false)" v-else>Mark as unread</button>
                    </div>

                </div>

                <div class="col-4 text-center">
                    <img src=" {{ $book->thumbnail }} " />
                </div>


            </div>

            <div class="row" id="readers_section" >
                <div class="col-12">
                        <div class="ml-1 mb-1 mt-5 w-100">
                            <h4 v-if="readers.length">Read by:</h4>
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
@endsection