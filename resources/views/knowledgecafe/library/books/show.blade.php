@extends('layouts.app')
@section('content')

<div class="container" id="show_book_info"
    data-book="{{ json_encode($book) }}"
    data-is-read="{{ $book->readers->contains(auth()->user()) }}"
    data-is-borrowed="{{ $book->borrowers->contains(auth()->user()) }}"
    data-is-book-a-month="{{ $isBookAMonth }}"
    data-mark-book-route= "{{ route('books.toggleReadStatus') }}"
    data-borrow-book-route= "{{ route('books.markAsBorrowed', $book->id) }}"
    data-put-back-book-route= "{{ route('books.putBack', $book->id) }}"
    data-readers = "{{ json_encode($book->readers) }}"
    data-book-a-month-store-route="{{ route('books.addToBam', $book->id) }}"
    data-book-a-month-destroy-route="{{ route('books.removeFromBam', $book->id) }}"
    data-borrowers = "{{ json_encode($book->borrowers) }}"
>

<div class="card mx-5">
    <div class="card-body">
        <h1 class="mt-1 mb-4 mx-2">{{ $book->title }}</h1>
        <div class="row">
            <div class="col-md-8 col-xl-9 d-flex">
                <div class="w-25p d-flex justify-content-center align-items-center">
                    <img src="{{ $book->thumbnail }}" alt="{{ $book->title }}" class="img-fluid">
                </div>
                <div class="pl-1 pl-xl-3 d-flex flex-column w-75">
                    <div class="ml-1 mb-1 d-flex">
                        <h4>Authors:</h4>
                        <span class="pl-5">{{ $book->author }}</span>
                    </div>
                    @if (! empty($book->categories))
                    <div class="ml-1 mb-1 d-flex">
                        <h4>Categories:</h4>
                        <div class="pl-3">
                            <ul class="pl-3 list-style-type-none">
                                @foreach($book->categories as $category)
                                <li>{{$category->name}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div>
                        @if($book->on_kindle)
                            <p class="text-info" v-if="book.on_kindle == 1" :title="book.author">On Kindle</p>
                        @endif
                    </div>
                    @endif
                    <div>
                        <div class="row mx-0" id="readers_section" >
                            <div class="ml-1 mb-1 mt-2 w-full d-flex align-items-center">
                                <p class="font-weight-bold mb-0 text-nowrap mr-2" v-if="borrowers.length">Borrowed by:</p>
                                <div class="d-flex justify-content-start flex-wrap">
                                    <div v-for="(borrower, index)  in borrowers " class="mr-2 text-center">
                                        <img :src="borrower.avatar" alt="" class="reader_image" data-toggle="tooltip" data-placement="top" :title="borrower.name">
                                    </div>
                                </div>
                            </div>
                            <div class="ml-1 mb-1 mt-2 w-full d-flex align-items-center">
                                <p class="font-weight-bold mb-0 text-nowrap mr-2" v-if="readers.length">Read by:</p>
                                <div class="d-flex justify-content-start flex-wrap">
                                    <div v-for="(reader, index)  in readers " class="mr-2 text-bottom">
                                        <img :src="reader.avatar" alt="" class="reader_image" data-toggle="tooltip" data-placement="bottom" :title="reader.name">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xl-3">
                <span class="d-block mb-1">
                    <button class="btn btn-success" @click="borrowTheBook()" v-if="!isBorrowed">I have this book</button>
                    <button class="btn btn-primary" @click="putTheBookBackToLibrary()" v-else>I have returned it</button>
                </span>
                <span class="d-block mb-1">
                    <button class="btn btn-secondary" @click="markBook(true)" v-if="!isRead">I have read this book</button>
                    <button class="btn btn-danger p-2" @click="markBook(false)" v-else>Mark as unread</button>
                </span>
                <span class="d-block mb-1">
                    <button type="button" class="btn btn-warning" @click="addToBookAMonth()" v-if="!isBookAMonth">Pick as Book of the Month</button>
                    <button type="button" class="btn btn-danger font-italic" @click="removeFromBookAMonth()" v-else>Unpick as Book of the Month</button>
                </span>
            </div>
        </div>
    </div>

    <h4 class="font-italic pl-5 mt-3 text-underline">Reader's thoughts</h4>

    <div class="mt-3 w-75">
        <books-comments-component
        :new-comment-route = "{{ json_encode(route('book-comment.store', $book->id)) }}"
        :book = "{{ json_encode($book) }}"
        :book-comments = "{{ json_encode($book->comments) }}"
        :user = "{{ auth()->user() }}"
        />
    </div>
</div>


@endsection
