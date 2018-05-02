@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('knowledgecafe.library.menu', ['active' => 'books'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Books</h1></div>
        <div class="col-md-6"><a href="{{ route('books.create') }}" class="btn btn-success float-right">Add Book</a></div>
    </div>

    <table class="table table-striped table-bordered" id="books_table">
        <tr>
            <th>Name</th>
            <th>Author</th>
            <th>Categories</th>
            <th>Cover Page</th>
            <th>Readable link</th>
        </tr>

        @foreach($books as $book)
            <tr>
                <td> 
                    <a href="{{ route('books.show', $book->id) }}"> 
                        {{ str_limit($book->title, 25) }} </a>
                    </td>
                <td> {{ str_limit($book->author, 20) }} </td>
                <td> {{ str_limit($book->categories, 20) }} </td>
                <td> 
                    <div class="w-25 h-75">
                        <img class="w-100" src="{{ $book->thumbnail }}" alt="No Image"> 
                    </div>
                </td>
                <td> 
                    <a target="_blank" class="btn btn-primary" href="{{ $book->readable_link }}">Read</a> 
                </td>
            </tr>
        @endforeach

    </table>
</div>
@endsection