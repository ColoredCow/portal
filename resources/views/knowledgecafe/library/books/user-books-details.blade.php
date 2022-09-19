@extends('layouts.app')
@section('content')<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  </head>
  <body style="background-color: rgba(177, 170, 129, 0.15); font-family: Muli, sans-serif;">
        <div class="container">
            <div class="mt-4 card">
                <div class="card-header">
                    <div class=" fs-1 my-3 mx-4 px-2"> User Details</div>
                </div>
                <div class="card-body">
                    <div class="fs-2 d-flex justify-content-between mx-4 px-2 align-items-end">{{$user->name}}</div>
                    <hr class='bg-dark mx-4 pb-0.5'></div>
                    <div class="mx-5">
                        <div class="container mb-3">
                            <div class="row">
                              <div class="col-sm border px-0">
                                <h4 class="card-header" style="color: #1B65D5">Wishlisted Books</h4>
                                @foreach ($user->booksInWishlist as $list)
                                <div class="px-3 py-2 border-bottom">
                                    {{$list->title}}
                                </div>
                                @endforeach
                              </div>
                              <div class="col-sm border px-0">
                                <h4 class="card-header" style="color: #0A6B51">Read Books</h4>
                                @foreach ($books['readBooks'] as $readBook)
                                <div class="px-3 py-2 border-bottom">
                                    {{$readBook->title}}
                                </div>
                                @endforeach
                              </div>
                              <div class="col-sm border px-0">
                                <h4 class="card-header"  style="color: #E32315">Borrowed Books</h4>
                                @foreach ($books['borrowedBooks'] as $borrowedBook)
                                <div class="px-3 py-2 border-bottom">
                                    {{$borrowedBook->title}}
                                </div>
                                @endforeach
                              </div>
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
  </body>
</html>
@endsection
