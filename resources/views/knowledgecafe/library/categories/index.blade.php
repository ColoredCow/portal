@extends('layouts.app')

@section('content')
<div class="container" id="books_category" v-cloak>
    <br>
    @include('knowledgecafe.library.menu', ['active' => 'book_category'])
    <br><br>

    <div class="row">
        <div class="col-md-6"><h1>Book Category</h1></div>
        <div class="col-md-6">
            <button @click="updateNewCategoryMode('add')" class="btn btn-success float-right">Add Category</button>
        </div>
    </div>

    <div id="category_container" 
        data-categories="{{ json_encode($categories) }}"
        data-index-route="{{ route('books.category.index') }}" 
        class ="table-bordered">

        <div class="row category_listing_header shadow-sm mx-0">
            <div class="col-6 category_listing_header_item ">
                <div class="category_header_lable d-flex mt-2 mb-2 font-weight-normal">
                    <p class="total-category-count mb-0"> {{ count($categories) }}</span>
                    <p class="lable pl-2 mb-0">Categories</span>
                </div>
            </div>
        </div>

        <div class="row py-3 border-bottom mx-0" v-if="newCategoryMode == 'add'">
            <div class="col-8">
                    <span>
                        <div class="d-flex justify-content-between">
                            <input class="form-control mr-3" type="text" v-model="newCategoryName" placeholder="Enter Category Name" autofocus>
                            <button type="button" class="btn btn-info btn-sm" @click="addNewCategory()" >Add</button>
                            <button type="button" class="btn btn-secondary btn-sm ml-4" @click="updateNewCategoryMode('cancel')" >Cancel</button>
                        </div>
                    </span>
            </div>
        </div>

        <div v-for="(category, index) in categories" class="row py-3 border-bottom mx-0">
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

            <div  class="col-4">
                <span v-if = "!category.assign_books_count">No book for this category</span> 
                <span v-else>
                    <span> @{{ category.assign_books_count }}</span> 
                    <span> @{{ (category.assign_books_count > 1) ? 'books' : 'book' }} </span>
                </span>
            </div>

            <div @click="showEditMode(index)" class="col-2">
                <button class="btn btn-primary">
                    <i class="fa fa-pencil"></i>&nbsp;Edit
                </button>
            </div>

            <div class="col-2 d-flex align-items-center" @click="deleteCategory(index)">
                    <div class="text-danger c-pointer">
                        <i class="fa fa-times"></i>&nbsp;Delete
                    </div>
            </div>
            </div>
        </div>
</div>


@endsection