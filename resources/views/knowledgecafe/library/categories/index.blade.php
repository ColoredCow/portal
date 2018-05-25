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
        data-index-route= "{{ route('books.category.index') }}" 
        class ="table-bordered">

        <div class="row category_listing_header shadow-sm">
            <div class="col-6 category_listing_header_item ">
                <div class="category_header_lable d-flex mt-2 mb-2 font-weight-normal">
                    <p class="total-category-count mb-0"> {{ count($categories) }}</span>
                    <p class="lable pl-2 mb-0">Categories</span>
                </div>
            </div>
        </div>

        <div v-for="(category, index) in categories" class="row py-3 border-bottom">
            <div class="col-4">
                <span v-if="category.editMode">
                    <div class="d-flex justify-content-between">
                        <input class="form-control mr-3" type="text" v-model="categoryNameToChange[index]">
                        <button type="button" class="btn btn-success btn-sm" @click="updateCategoryName(index)" >Save</button>
                    </div>
                </span>

                <span v-else >
                    @{{ category.name }}
                </span>

            </div>

            <div v-if = "!category.assign_books_count" class="col-4">
                <span>No book for this category</span> 
            </div>
            
            <div v-if = "category.assign_books_count" class="col-4">
                <span> @{{ category.assign_books_count }}</span> 
                <span> @{{ (category.assign_books_count > 1) ? 'books' : 'book' }} </span>
            </div>

            <div @click="showEditMode(index)" class="col-2">
                <a href="#">
                    <i class="fa fa-pencil"></i>&nbsp;<u>Edit</u>
                </a>
            </div>

            <div class="col-2">
                <a href="#">
                    <i class="fa fa-times"></i>&nbsp;<u>Delete</u>
                </a>
            </div>
            </div>
        </div>

</div>


@endsection