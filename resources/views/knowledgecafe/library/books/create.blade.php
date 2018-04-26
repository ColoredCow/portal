@extends('layouts.app')
@section('content')
<div class="container">

    <span id = "add_book">
        <br>
        <br><br>
        <h1>Add Book</h1>
        @include('status', ['errors' => $errors->all()])
        <div class="card">
            <form action="/knowledgecafe/library/books" method="POST" id="book_form" enctype="multipart/form-data">
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
                            <input type="text" class="form-control" name="isbn" id="isbn" placeholder="978...." value="{{ old('isbn') }}">
                        </div>
                    </div>

                    <div class="form-row"> 
                        <div class="form-group col-md-5" v-if="addMethod === 'from_image'">
                            <label for="phone">Capture Image</label>
                            <input type="file" class="form-control" name="book_image" id="book_image" >
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="submit_book_form_btn" >Show</button>
                </div>
            </form>
        </div>
    </span>
    
    <span id = "show_book">
    </span>


</div>
@endsection
