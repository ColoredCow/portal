@extends('layouts.app')
@section('content')<!doctype html>
    <body style="background-color: #b1aa8126; font-family: Muli, sans-serif;">
		<div class="container">
			<div class="mt-4 card">
				<div class="card-header">
					<div class="fs-1 my-2 mx-4 px-2"><h3>Personal Library of {{$user->name}}</h3></div>
				</div>
				<div class="mx-5">
					<div class="container mb-3">
						<div class="mt-3 row">
							<div class="col-sm border px-0">
							<h4 class="card-header text-primary">Wishlisted Books({{$books['wishlistBookCount']}})</h4>
							@foreach ($user->booksInWishlist as $list)
							<div class="px-3 py-2 border-bottom">
								{{$list->title}}
							</div>
							@endforeach
							</div>
							<div class="col-sm border px-0">
							<h4 class="card-header text-success">Read Books({{$books['readBookCount']}})</h4>
							@foreach ($books['readBooks'] as $readBook)
							<div class="px-3 py-2 border-bottom">
								{{$readBook->title}}
							</div>
							@endforeach
							</div>
							<div class="col-sm border px-0">
							<h4 class="card-header text-danger">Borrowed Books({{$books['borrowedBookCount']}})</h4>
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
    </body>
@endsection
