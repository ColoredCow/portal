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

        <div v-for="(book, index) in books" class="card mb-4 mr-4 book_card">
            <a target="_blank" :href="book.readable_link">
                <img :src="book.thumbnail" class="mw-100">
            </a>
            
            <div class="card-body p-1 flex-grow-0">
                <h5 class="card-title font-weight-bold mb-1" :title="book.title">@{{ strLimit(book.title, 20) }}</h5>
                <p class="text-dark" :title="book.author" >@{{ strLimit(book.author, 20) }} </p>
            </div>

            <div 
                :class=" (!book.readers.length) ? 'card-body p-1 flex-grow-0 pb-5' : 'card-body p-1 flex-grow-0'">
                <span v-for="category in book.categories">
                    <h6 class="badge badge-light px-2">@{{ category.name }} </h6>
                    <br>
                </span>
                
            </div>

            <div v-if="book.readers && book.readers.length">
                <div class="pt-0 pb-5 px-2">
                    <img v-for ="reader in book.readers" 
                        :src="reader.avatar" 
                        :alt="reader.name"
                        :title="reader.name" 
                        class="reader_image m-1" 
                        data-toggle="tooltip" 
                        data-placement="bottom">
                </div>
            </div>

            <div class="card-body p-0 action_buttons_container">
                <a 
                    href="#" 
                    class="card-link btn change_category_btn"  
                    data-toggle="modal" 
                    data-target="#update_category_modal" 
                    v-show="!book.showCategories" 
                    class="btn btn-info btn-sm mt-1 ml-4" 
                    @click="updateCategoryMode(index)">
                    <i class="fa fa-pencil"></i>
                </a>
                
                <a 
                    href="#" 
                    class="card-link text-danger btn delete_book_btn" 
                    style="position:absolute;bottom:0px;right: 0;" 
                    @click="deleteBook(index)">Delete</a>
            </div>
        </div>
    </div>

    @include('knowledgecafe.library.books.update-category-modal')
</div>


@endsection