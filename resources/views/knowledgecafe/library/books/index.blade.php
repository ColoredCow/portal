@extends('layouts.app')

@section('content')
<div class="container" id="books_listing">
    <br>
    @include('knowledgecafe.library.menu', ['active' => 'books'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Books</h1></div>
        @can('library_books.create')
            <div class="col-md-6 d-none"><a href="{{ route('books.create') }}" class="btn btn-success float-right">Add Book</a></div>
        @endcan

    </div>
    
    <div class="d-flex justify-content-start flex-wrap" id="books_table"
        data-books="{{ json_encode($books) }}" 
        data-categories="{{ json_encode($categories) }}"
        data-index-route = "{{ route('books.index') }}"
        data-category-index-route = "{{ route('books.category.index') }}">

        <div v-for = "book in books" class="card m-2 book_card ">
            <a target="_blank" :href="book.readable_link">
                <img :src="book.thumbnail">
            </a>
            
            <div class="card-body py-0">
                <p class="card-title d-inline font-weight-bold">@{{ book.title }}</p>
                <p class="card-text">@{{ book.author }} </p>
               
            </div>

            <div class="card-body pt-0 pb-5" v-if="book.readers">
                    <img v-for ="reader in book.readers" 
                        :src="reader.avatar" 
                        :alt="reader.name"
                        :title="reader.name" 
                        class="reader_image m-1" 
                        data-toggle="tooltip" 
                        data-placement="bottom">
            </div>

            <div class="card-body p-0" style="bottom:0px;position:relative">
                <a href="#" class="card-link btn" style=" position:absolute;bottom:  0px;left: 0;">Change cate...</a>
                <a href="#" class="card-link text-danger btn" style="position:absolute;bottom:0px;right: 0;" >Delete</a>
            </div>
        </div>
    </div>

    @include('knowledgecafe.library.books.update-category-modal')
</div>


@endsection