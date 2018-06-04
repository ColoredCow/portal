@extends('layouts.app')

@section('content')
<div class="container" id="books_listing">
    <br>
    @include('knowledgecafe.library.menu', ['active' => 'books'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Books&nbsp;({{ $books->total() }})</h1></div>
        @can('library_books.create')
            <div class="col-md-6"><a href="{{ route('books.create') }}" class="btn btn-success float-right">Add Book</a></div>
        @endcan
    </div>
    
<table class="table table-striped table-bordered" 
        id="books_table"
        data-books="{{ json_encode($books) }}" 
        data-categories="{{ json_encode($categories) }}"
        data-index-route = "{{ route('books.index') }}"
        
        data-category-index-route = "{{ route('books.category.index') }}" >
        <tr>
            <th>Name</th>
            <th>Author</th>
            <th>Categories</th>
            <th>Cover Page</th>
            @can('library_books.delete')
            <th></th>
            @endcan
        </tr>
        <tr v-for="(book, index) in books" >
            <td> 
                <a :href = "'/knowledgecafe/library/books/' + book.id"> 
                   <h5>@{{ book.title }}</h5> 
                </a>
            </td>
             <td> 
                @{{ book.author }} 
            </td>

            <td>
                <div>
                   <ul>
                       <li v-for="category in book.categories" >
                           @{{category.name}}
                       </li>
                   </ul>
                </div>


                @can('library_books.update')
                    <div>
                        <button data-toggle="modal" data-target="#update_category_modal" v-show="!book.showCategories" class="btn btn-info btn-sm mt-1 ml-4" @click="updateCategoryMode(index)">Change</button>
                    </div>  
                @endcan
            </td>
            
            <td> 
                <div class="w-25 h-75">
                    <a target="_blank" :href="book.readable_link">
                        <img class="w-100" :src="book.thumbnail" alt="No Image"> 
                    </a>
                    
                </div>
            </td> 
            @can('library_books.delete')
            <td>
                <div @click="deleteBook(index)" class="text-danger c-pointer ml-3"><i class="fa fa-times"></i>&nbsp;Delete</div>
            </td>
            @endcan
        </tr>

    </table>
    @include('knowledgecafe.library.books.update-category-modal')
    {{ $books->links() }}
</div>


@endsection