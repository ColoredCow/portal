@extends('layouts.app')

@section('content')
<div class="container" id="books_listing">
    <br>
    @include('knowledgecafe.library.menu', ['active' => 'books'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Books</h1></div>
        @can('library_books.create')
            <div class="col-md-6"><a href="{{ route('books.create') }}" class="btn btn-success float-right">Add New Book</a></div>
        @endcan
    </div>

    <div class="row mt-3 mb-2">
        <div class="col-4 d-flex justify-content-center align-items-center">
            <input type="text" data-value="{{ request()->input('search') }}" class="form-control" id="search_input" placeholder="search all books" v-model="searchKey" >
            <button class="btn btn-info ml-2" @click="searchBooks()">Search</button>
        </div>
    </div>
    
    @if(request()->has('search'))
            <div class="row mt-3 mb-2">
                <div class="col-6">
                    <a class="text-muted c-pointer" href="{{ route('books.index') }}">
                        <i class="fa fa-times"></i>&nbsp;Clear current search query, filters, and sorts
                    </a>
                </div>
            </div>
    @endif
    
    <div class="d-flex justify-content-start flex-wrap" id="books_table"
        data-books="{{ json_encode($books) }}" 
        data-categories="{{ json_encode($categories) }}"
        data-index-route = "{{ route('books.index') }}"
        data-category-index-route = "{{ route('books.category.index') }}">

        <div v-for="(book, index) in books" class="card mb-4 mr-4 book_card">
            <div class="d-flex h-50">
                <a target="_blank" :href="book.readable_link">
                    <img :src="book.thumbnail" class="w-100 h-100">
                </a>
                
                <div class="card-body px-2 pb-5 w-50">
                    <a target= "_blank" :href="updateRoute+ '/'+ book.id" class="card-title font-weight-bold mb-1 h4" :title="book.title">@{{ strLimit(book.title, 100) }}</a>
                    <p class="text-dark" :title="book.author" >@{{ strLimit(book.author, 20) }} </p>
                </div>
            </div>

            <div v-if="book.readers && book.readers.length" class="p-2">
                <img v-for ="reader in book.readers" 
                    :src="reader.avatar" 
                    :alt="reader.name"
                    :title="reader.name" 
                    class="reader_image m-1" 
                    data-toggle="tooltip"
                    data-placement="bottom"
                />
            </div>

            <div v-else class="p-2 mt-1">
                <h6 class="text-muted">Not read by anyone yet</h6>
            </div>

            <div class="card-body p-1 flex-grow-0">
                <span v-for="category in book.categories">
                    <h5 class="badge badge-light px-2">@{{ category.name }} </h5>
                </span> 
            </div>

            @can('library_books.delete')

            <div class="card-body p-0 position-relative action_buttons">
                <div class="dropdown position-absolute">
                    <a href="#" class="m-1 text-dark h4" data-toggle="dropdown">
                        <i class="fa fa-cog"></i>
                    </a>

                    <ul class="dropdown-menu ">
                        <li @click="updateCategoryMode(index)" data-toggle="modal" 
                        data-target="#update_category_modal" class="dropdown-item">Update Category</li>
                        <li @click="deleteBook(index)" class="dropdown-item text-danger">Delete</li>
                    </ul>
                </div>
            </div>

            @endif

        </div>
    </div>

    @include('knowledgecafe.library.books.update-category-modal')
</div>


@endsection
