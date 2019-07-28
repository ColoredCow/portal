@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('knowledgecafe.library.menu', ['active' => 'book_a_month'])
    <br><br>

    <div class="row mb-2">
        <div class="col-md-6"><h1>Book A Month</h1></div>
    </div>

    <div class="container px-md-0">
        @foreach ($booksCollection as $year => $yearBooks)
            @foreach ($yearBooks as $month => $monthlyBooks)
                <div class="accordion" id="accordion_{{$month}}_{{$year}}">
                    <div class="card border-bottom">
                        <div class="card-header">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_{{$month}}_{{$year}}" aria-expanded="true" aria-controls="collapse{{$month}}_{{$year}}">
                                    {{ config("constants.months.{$month}") }} - {{ $year }}
                                </button>
                            </h2>
                        </div>

                        <div id="collapse_{{$month}}_{{$year}}" class="collapse" data-parent="#accordion_{{$month}}_{{$year}}">
                            <div class="card-body">
                                <ol>
                                    @foreach ($monthlyBooks as $userBookAMonth)
                                        <li><strong>{{ $userBookAMonth->user->name }}</strong> has picked <a href="{{ route('books.show', $userBookAMonth->book) }}">{{ $userBookAMonth->book->title }}</a>.</li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</div>
@endsection
