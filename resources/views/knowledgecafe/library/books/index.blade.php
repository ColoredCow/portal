@extends('layouts.app') @section('content')
<div id="books_listing" class="container">
    <br> @include('knowledgecafe.library.menu', ['active' => 'books'])
    <br>
    <br>
    <div class="row">
        <div class="col-md-6">
            <h1>Books</h1>
        </div>
        @can('library_books.create')
        <div class="col-md-4">
            <a href="{{ route('books.create') }}" class="btn btn-success float-right">Add New Book</a>
        </div>
        @endcan
    </div>

    <div class="row mt-3 mb-2">
        <div class="col-4 d-flex justify-content-center align-items-center">
            <input type="text" data-value="{{ request()->input('search') }}" class="form-control" id="search_input" placeholder="search all books"
                v-model="searchKey">
            <button class="btn btn-info ml-2" @click="searchBooks()">Search</button>
        </div>
    </div>

    @if(request()->has('search'))
    <div class="row mt-3 mb-2">
        <div class="col-6">
            <a class="text-muted c-pointer" href="{{ route('books.index') }}">
                <i class="fa fa-times"></i>&nbsp;Clear current search and filters
            </a>
        </div>
    </div>
    @endif

    <div class="d-flex justify-content-start flex-wrap" id="books_table" data-books="{{ json_encode($books) }}" data-categories="{{ json_encode($categories) }}"
        data-index-route="{{ route('books.index') }}" data-category-index-route="{{ route('books.category.index') }}">

        <div class="row pl-3">
            <div v-for="(book, index) in books" class="card book_card col-md-3 col-12 mr-2 mb-2 p-2">
                <div class="d-flex" >
                    <a target="_blank" :href="book.readable_link">
                        <img :src="book.thumbnail" style="max-height:10em;">
                    </a>

                    <div class="pl-2 pr-4">
                        <a target="_blank" :href="updateRoute+ '/'+ book.id" class="card-title font-weight-bold mb-1 h5" :title="book.title">@{{ strLimit(book.title, 24) }}</a>
                        <p class="text-dark" :title="book.author">@{{ strLimit(book.author, 20) }} </p>
                    </div>

                    @can('library_books.delete')

                    <div class="p-0 position-absolute action_buttons">
                        <div class="dropdown ">
                            <a href="#" class="m-1 mr-2 text-muted h4" data-toggle="dropdown">
                                <i class="fa fa-bars"></i>
                            </a>
    
                            <ul class="dropdown-menu ">
                                <li @click="updateCategoryMode(index)" data-toggle="modal" data-target="#update_category_modal" class="dropdown-item">Update Category</li>
                                <li @click="deleteBook(index)" class="dropdown-item text-danger">Delete</li>
                            </ul>
                        </div>
                    </div>
    
                    @endif

                </div>

                <div v-if="book.readers && book.readers.length" class="p-2">
                        <img v-for="reader in book.readers" :src="reader.avatar" :alt="reader.name" :title="reader.name" class="reader_image m-1"
                            data-toggle="tooltip" data-placement="bottom" />
                </div>

                <div :class="(book.readers && book.readers.length) ? 'card-body p-1' : 'card-body p-1'">
                    <span v-for="(category, index) in book.categories">
                        <h2 v-if="index < 3" class="badge badge-info p-2 mr-1">@{{ category.name }} </h2>
                    </span>
                </div>
            </div>
        </div>
    </div>

    @include('knowledgecafe.library.books.update-category-modal')
</div>


@endsection