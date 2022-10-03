@extends('layouts.app')
@section('content')
<div class="text-center d-block bg-white position-fixed top-0 bottom-0 w-100p h-100p mx-10 ml-n4 z-index-100" id="preloader">
    <div class="spinner-border position-relative top-50p" id="spinner">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<div id="books_listing" class="container">
    @include('status', ['errors' => $errors->all()])
    <br>

    @include('knowledgecafe.library.menu', ['active' => 'books'])
    <br>
    <br>
    <div class="row">
        <div class="col-6">
            <h1>Books</h1>
        </div>
        @can('library_books.create')
        <div class="col-6">
            <a href="{{ route('books.create') }}" class="btn btn-success float-right"><i class="fa fa-plus mr-1"></i> Add New Book</a>
        </div>
        @endcan
    </div>
    <div class="row mt-3 mb-2 px-2">
        <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12 mr-2 mb-2 p-2 d-flex justify-content-center align-items-center">
            <input type="text" data-value="{{ request()->input('search') }}" class="form-control" id="search_input" placeholder="Enter the book name" v-model="searchKey">
            <button class="btn btn-info ml-2 py-1.5" @click="searchBooks()">Search</button>
        </div>
        <div>
            <div class="col-lg-12 col-md-5 col-sm-6 col-xs-12 mr-2 mb-2 p-2 d-flex justify-content-center ">
                <select class="form-control bg-white form-control-st col-15" id="category_input" data-value="{{request()->input('category_name')}}" v-model="sortKeys">
                    <option value=""selected>Sort Book By Category</option>
                @foreach ($categories as $category)
                    <option {{request()->input('category_name') == $category->name ? "selected" : "" }}>
                        {{ $category->name }}
                    </option>
                @endforeach
                </select>
                <button type="submit" class="btn btn-info ml-2" @click="searchBooksByCategoryName()">Sort</button>
            </div>
        </div>
        @if(session('disable_book_suggestion'))
        <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12 mb-2 p-2 text-right offset-lg-3">
            <a href="{{ route('books.enableSuggestion') }}">Show me suggestions on the dashboard</a>
        </div>
        @endif
    </div>
    @if(request()->has('search') || request()->has('category_name'))
    <div class="row mt-3 mb-2">
        <div class="col-6">
            <a class="text-muted c-pointer" href="{{ route('books.index') }}">
                <i class="fa fa-times"></i>&nbsp;Clear current search and filters
            </a>
        </div>
    </div>
    @endif
    <div class="d-flex justify-content-start flex-wrap" id="books_table" 
        data-books="{{ json_encode($books) }}" 
        data-categories="{{ json_encode($categories) }}"
        data-index-route="{{ route('books.index') }}" 
        data-reader-index-route="books/reader" 
        data-category-index-route="{{ route('books.category.index') }}"
        data-logged-in-user="{{ json_encode(auth()->user()) }}">
    <div class="d-flex justify-content-start flex-wrap" id="books_table" data-books="{{ json_encode($books) }}" data-categories="{{ json_encode($categories) }}" data-index-route="{{ route('books.index') }}" data-category-index-route="{{ route('books.category.index') }}" data-logged-in-user="{{ json_encode(auth()->user()) }}">
        <div class="d-flex flex-wrap w-full">
            <div v-for="(book, index) in books" class="col-lg-3 col-md-5 col-8 card book_card  mr-1 mb-3 p-2 mr-lg-4">
                <div class="d-flex">
                    <a :href="updateRoute+ '/'+ book.id">
                        <img :src="book.thumbnail" class="cover_image">
                    </a>
                    <div class="pl-2 pr-3 mr-1">
                        <a :href="updateRoute+ '/'+ book.id" class="card-title font-weight-bold mb-1 h6" :title="book.title">@{{ strLimit(book.title, 35) }}</a>
                        <p class="text-dark" :title="book.author">@{{ strLimit(book.author, 20) }} </p>

                        <p class="text-info" v-if="book.on_kindle == 1" :title="book.author">On Kindle</p>

                        <h3><span class="badge badge-primary position-absolute copies-count" v-if="book.number_of_copies > 1" :title="book.number_of_copies + ' copies'">@{{ book.number_of_copies }}</span></h3>
                    </div>
                    @can('library_books.delete')
                    <div class="p-0 position-absolute action_buttons">
                        <div class="dropdown">
                            <a href="#" class="m-1 mr-2 text-muted h4" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                            </a>
                            <ul class="dropdown-menu ">
                                <li @click="updateCategoryMode(index)" data-toggle="modal" data-target="#update_category_modal" class="dropdown-item">Update Category</li>
                                <li @click="updateIndex(index)" data-toggle="modal" :data-target="'#copiesOfBooksCountModal' + index" class="dropdown-item">Copies Available</li>
                                <li @click="deleteBook(index)" class="dropdown-item text-danger">Delete</li>
                            </ul>
                        </div>
                    </div>
                    @endcan
                </div>
                <div class="modal fade" :id="'copiesOfBooksCountModal' + index" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">Number of copies of this book: <br> <input type="text" name="copiesofbooks" :id="'copiesOfBooks'+index" :value="book.number_of_copies"> </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" @click="updateCopiesCount(index)" data-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="book.readers && book.readers.length">
                    <p class="mb-0 mt-1">Read by</p>
                    <div class="pl-0 pt-2 pb-3">
                        <a v-for="reader in book.readers"  :href="readerIndexRoute+ '/'+ reader.id">
                        <img :src="reader.avatar" :alt="reader.name" :title="reader.name" class="reader_image mr-2 rounded-circle" data-toggle="tooltip" data-target="userDetails" data-placement="bottom">
                        </a>
                    </div>
                </div>

                <div v-if="book.borrowers && book.borrowers.length">
                    <p class="mb-0 mt-1">Borrowed by</p>
                    <div class="pl-0 pt-2 pb-3">
                        <img v-for="borrower in book.borrowers" :src="borrower.avatar" :alt="borrower.name" :title="borrower.name" class="reader_image mr-2 rounded-circle" data-target="userDetails" data-toggle="tooltip" data-placement="bottom">
                    </div>
                </div>

                <div :class="(book.readers && book.readers.length) ? 'pl-0 pt-1' : 'pl-0 pt-1 mt-3'">
                    <span v-for="(category, index) in book.categories">
                        <h2 v-if="index < 3" class="badge badge-secondary px-2 py-1 mr-1">@{{ category.name }} </h2>
                    </span>
                </div>

                <div>
                    <span>
                        <h2 class="badge badge-warning px-2 py-1 mr-1">@{{ book.wishers.find(user => user.id == loggedInUser.id) == null ? '' : 'Wishlisted' }}</h2>
                    </span>
                </div>
            </div>
        </div>
    </div>
    @include('knowledgecafe.library.books.update-category-modal')
</div>
@endsection
