<div class="modal fade"
    id="show_nudge_modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="show_nudge_modal"
    aria-hidden="true"
    >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h6 class="modal-title">you have read <b>{{ auth()->user()->totalReadBooks() }}</b> books out of {{ $book->totalBooksCount }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body ml-5">
                <div class="row">
                    <div class="col-6">
                        <a class="" href="{{ route('books.index', ['search'=> $book->title]) }}">
                            <img class="mb-1 mw-100" src=" {{ $book->thumbnail }} " />
                        </a>
                        <h5 class="mb-1 font-weight-bold" > {{ $book->title }} </h5>
                        <h6 class="mb-1" > {{ $book->author }} </h6>
                    </div>

                    <div class="col-5">
                            <button type="button"
                                data-id="{{$book->id}}"
                                data-mark-book-route= "{{route('books.toggleReadStatus')}}"
                                id="markBookAsRead"
                                class="btn btn-primary m-2 w-100 py-3 font-weight-bold">Yes, I have read this
                            </button>

                            <button type="button"
                                data-dismiss="modal"
                                data-id="{{$book->id}}"
                                data-route = {{ route('books.addToWishList') }}
                                id="addBookToWishlist"
                                class="btn btn-info m-2 w-100 py-3 font-weight-bold">I wish to read it
                            </button>

                            @if($book->readers->count())
                                <div id="readers_section" class="mb-1">
                                    <div class="d-flex justify-content-start">
                                        @foreach($book->readers as $reader)
                                            <div class="my-3 ml-2 text-center">
                                                <img
                                                    data-toggle="tooltip"
                                                    title="{{ $reader->name }}"
                                                    data-placement="bottom"
                                                    class="reader_image"
                                                    src="{{ $reader->avatar}}"
                                                    alt="{{ $reader->name }}"/>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                                    <a class="m-2 w-100 py-3 font-weight-bold" id="disableBookSuggestion" data-dismiss="modal" aria-label="Close" data-href= "{{ route('books.disableSuggestion') }}">
                                        <label>
                                            <input type="checkbox">Don't show me this again
                                        </label>
                                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
