@extends('layouts.app') @section('content')
<div class="container">
    <span id="show_and_save_book"  >
        <span id="add_book" v-show="!showInfo">
            <br>
            <br>
            <br>
            <h1>Add Book</h1>
            @include('status', ['errors' => $errors->all()])
            <div class="card">
                <form data-action-route="{{ route('books.fetchInfo') }}" action="#"  id="book_form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="name" class="field-required">How to Add @{{addMethod}}</label>
                                <select class="form-control" name="add_method" id="add_method" v-model="addMethod">
                                    <option value="from_image">Click Image</option>
                                    <option value="from_isbn">ISBN number</option>
                                </Select>
                            </div>
                        </div>
                        <br>
                        <div class="form-row" v-if="addMethod === 'from_isbn'">
                            <div class="form-group col-md-5">
                                <label for="isbn">ISBN</label>
                                <input  type="text" class="form-control" name="isbn" id="isbn" placeholder="978...." value="{{ old('isbn') }} " autofocus>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-5" v-if="addMethod === 'from_image'">
                                <label for="phone">Capture Image</label>
                                <input @change="onFileSelected" type="file" class="form-control" name="book_image" id="book_image">
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="button"
                            data-loading-text="Loading..." 
                            v-on:click="submitBookForm" 
                            class="btn btn-primary" 
                            id="submit_book_form_btn">
                            <i class="fa fa-spinner fa-spin d-none item"></i>
                            <span class="item">Show</span>
                        </button>
                    </div>
                </form>
            </div>
        </span>

        <span id="show_book" v-show="showInfo" data-store-route = "{{ route('books.store') }}" data-index-route = "{{ route('books.index') }}" >
            @include('knowledgecafe.library.books.info')
        </span>
        
    </span>

</div>
@endsection