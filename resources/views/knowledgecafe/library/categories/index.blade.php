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

    <div class="row mt-3 mb-2">
        <div class="col-12">
            <h4 class="font-weight-bold"><span>@{{ categories.length }}</span>&nbsp;Categories</h4>
        </div>
    </div>

    <div id="category_container" 
        data-categories="{{ json_encode($categories) }}"
        data-index-route="{{ route('books.category.index') }}" 
        class ="table-bordered">


        <div class="row py-3 border-bottom mx-0" v-if="newCategoryMode == 'add'">
            <div class="col-lg-8 d-flex justify-content-between">
                <input class="form-control mr-3" type="text" v-model="newCategoryName" placeholder="Enter Category Name" autofocus>
                <button type="button" class="btn btn-info px-3 mr-2" @click="addNewCategory()" >Add</button>
                <button type="button" class="btn btn-secondary px-3" @click="updateNewCategoryMode('cancel')" >Cancel</button>
            </div>
        </div>

        <div v-for="(category, index) in categories" class="row py-3 border-bottom mx-0">
            <div class="col-lg-4">
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

            <div  class="col-lg-4">
                <span v-if = "!category.assign_books_count">No book for this category</span> 
                <span v-else>
                    <span> @{{ category.assign_books_count }}</span> 
                    <span> @{{ (category.assign_books_count > 1) ? 'books' : 'book' }} </span>
                </span>
            </div>

            <div class="col-lg-4 d-flex align-items-center justify-content-end">
                <div  @click="showEditMode(index)">
                   <button class="btn btn-primary">
                    <i class="fa fa-pencil"></i>&nbsp;Edit
                   </button>
                </div>
                
                <div class="btn btn-danger text-white c-pointer ml-3" @click="deleteCategory(index)">
                    <i class="fa fa-times"></i>&nbsp;Delete
                </div>
            </div>

        </div>
    </div>
</div>


@endsection