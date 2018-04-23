@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('knowledgecafe.library.menu', ['active' => 'books'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Books</h1></div>
        <div class="col-md-6"><a href="/knowledgecafe/library/book/create" class="btn btn-success float-right">Add Book</a></div>
    </div>

    <table class="table table-striped table-bordered" id="books_table">
        <tr>
            <th>Name</th>
            <th>Author</th>
            <th>Categories</th>
            <th>ISBN</th>
            <th>Cover Page</th>
            <th>Readable link</th>
        </tr>
    </table>
</div>
@endsection
