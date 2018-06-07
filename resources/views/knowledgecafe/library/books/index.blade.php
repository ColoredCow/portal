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
                <img class="w-100" :src="book.thumbnail">
            </a>
            
            <div class="card-body">
                <h6 class="card-title d-inline font-weight-bold">@{{ book.title }}</h6>
                <p class="card-text">@{{ book.author }} </p>
                <p>
                    categories:
                    <span v-for="(category, catIndex) in book.categories" >
                            @{{ (catIndex) ? category.name + ',' : category.name }}
                    </span>
                </p>


                <div v-if="book.readers" class="d-flex" >
                    <img v-for ="reader in book.readers" :src="reader.avatar" style="width:40px; height:40px" alt="">
                </div>



            </div>
        </div>
    </div>

    @include('knowledgecafe.library.books.update-category-modal')
</div>


@endsection