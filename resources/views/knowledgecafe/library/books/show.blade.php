@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h1 class="mt-1 mb-4 mx-2">
                {{ $book->title }}
            </h1>

            <div class="row">
                <div class="col-6">
                    <div class="ml-1 mb-1">
                        <div class="row">
                            <div class="col-3">
                                <p>
                                    <b> Authors: </b>
                                </p>
                            </div>
                            <div class="col-6">
                                {{ $book->author }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">
                                <p>
                                    <b> Read : </b>
                                </p>
                            </div>
                            <div class="col-6">
                                <p>
                                    <a class="btn btn-primary"  href="{{ $book->readable_link }}">Read</a>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">
                                <p>
                                    <b>Category : </b>
                                </p>
                            </div>
                            <div class="col-6">
                                {{ $book->categories }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">
                                <p>
                                    <b>ISBN : </b>
                                </p>
                            </div>
                            <div class="col-6">
                                {{ $book->isbn }}
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-6">
                    <div class="row">
                        <div class="col-6">
                            <img src=" {{ $book->thumbnail }} " />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection