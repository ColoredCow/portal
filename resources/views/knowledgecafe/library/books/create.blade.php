@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <br><br>
    <h1>Add Book</h1>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="/knowledgecafe/library/book" method="POST" id="book_form" enctype="multipart/form-data">
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
                        <label for="phone">ISBN</label>
                        <input type="text" class="form-control" name="isbn" id="isbn" placeholder="ISBN Number" value="{{ old('isbn') }}">
                    </div>
                </div>

                <div class="form-row"> 
                    <div class="form-group col-md-5" v-if="addMethod === 'from_image'">
                        <label for="phone">Capture Image</label>
                        <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" value="{{ old('isbn') }}">
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
