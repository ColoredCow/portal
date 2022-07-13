@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('knowledgecafe.library.menu', ['active' => 'book_a_month'])
    <br><br>

    <div class="row mb-2">
        <div class="col-md-6"><h1>A book a month</h1></div>
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
                                        <li class="mb-2">
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0">
                                                    @if (optional($userBookAMonth->user)->id === auth()->user()->id)
                                                        <strong>You</strong> have picked
                                                    @else
                                                        <strong>{{ optional($userBookAMonth->user)->name }}</strong> has picked
                                                    @endif
                                                    <a href="{{ route('books.show', $userBookAMonth->book) }}">{{ $userBookAMonth->book->title }}</a>.
                                                </p>
                                                @if($userBookAMonth->book->readers->contains($userBookAMonth->user))
                                                    <span class="ml-auto badge badge-success font-size-100">Completed</span>
                                                @else
                                                    <span class="ml-auto badge badge-warning font-size-100">Reading</span>
                                                @endif
                                            </div>
                                        </li>
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
