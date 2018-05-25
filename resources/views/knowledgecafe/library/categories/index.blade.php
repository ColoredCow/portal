@extends('layouts.app')

@section('content')
<div class="container" id="books_category">
    <br>
    @include('knowledgecafe.library.menu', ['active' => 'book_category'])
    <br><br>

    <div class="row">
        <div class="col-md-6"><h1>Book Category</h1></div>
        <div class="col-md-6"><a href="{{ route('books.create') }}" class="btn btn-success float-right">Add Category</a></div>
    </div>

    <div id="category_container"
         data-categories="{{ json_encode($categories) }}"  
         class ="table-bordered">

        <div class="row category_listing_header shadow-sm">
            <div class="col-6 category_listing_header_item ">
                <div class="category_header_lable d-flex mt-2 mb-2 font-weight-normal">
                    <p class="total-category-count mb-0">20</span>
                    <p class="lable pl-2 mb-0">Categories</span>
                </div>
            </div>
        </div>

        <div v-for="(category, index) in categories" class="row py-3">
            <div class="col-3">@{{ category.name }}</div>
                <div class="col-3">
                    <span>Assign to</span> 
                    <span>3</span> 
                    <span> books</span>
                </div>
                <div class="col-3">Edit</div>
                <div class="col-3">Delete</div>
            </div>
        </div>

</div>


@endsection