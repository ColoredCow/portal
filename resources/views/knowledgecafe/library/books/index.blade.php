@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('knowledgecafe.library.menu', ['active' => 'books'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Books</h1></div>
        <div class="col-md-6"><a href="/knowledgecafe/library/books/create" class="btn btn-success float-right">Add Book</a></div>
    </div>

    <table class="table table-striped table-bordered" id="books_table">
        <tr>
            <th>Name</th>
            <th>Author</th>
            <th>Categories</th>
            <th>Readable link</th>
        </tr>

        @foreach($books as $book)
            <tr>
                <td> 
                    <a target="_blank"  href="{{ route('books.show', $book->id) }}"> 
                        {{ $book->title }} </a>
                    </td>
                <td> {{ $book->author }} </td>
                <td> {{ $book->categories }} </td>
                <td> 
                    <a target="_blank" class="btn btn-primary" href="{{ $book->readable_link }}">Read</a> 
                </td>
            </tr>
        @endforeach

    </table>
</div>
@endsection