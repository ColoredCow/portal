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
                <h6 class="modal-title">
                    <span>You have read</span>    
                    <span>{{ auth()->user()->totalReadBooks() }}</span> 
                    <span>books out of</span>     
                    <span>{{ $book->totalBooksCount }}</span>
                </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <a class="" href="{{ route('books.index', ['search'=> $book->title]) }}">
                            <img class="mb-1 mw-full" src=" {{ $book->thumbnail }} " />
                        </a>
                        <h5 class="mb-1 font-weight-bold" > {{ $book->title }} </h5>
                        <h6 class="mb-1" > {{ $book->author }} </h6>
                    </div>

                    <div class="col-6">
                            <button type="button"
                                data-id="{{$book->id}}"
                                data-mark-book-route= "{{route('books.toggleReadStatus')}}"
                                id="markBookAsRead"
                                class="btn btn-primary w-full py-3 font-weight-bold">Yes, I have read this
                            </button>

                            <button type="button"
                                data-dismiss="modal"
                                data-id="{{$book->id}}"
                                data-route = {{ route('books.addToWishList') }}
                                id="addBookToWishlist"
                                class="btn btn-info w-full py-3 font-weight-bold mt-3">I wish to read it
                            </button>

                            @if($book->readers->count())
                                <div id="readers_section" class="mt-3">
                                    <div class="d-flex justify-content-start flex-wrap">
                                        @foreach($book->readers as $reader)
                                            <div class="text-center mr-2">
                                                <img
                                                    data-toggle="tooltip"
                                                    title="{{ $reader->name }}"
                                                    data-placement="bottom"
                                                    class="reader_image"
                                                    src="{{ $reader->avatar}}"
                                                    alt="{{ $reader->name }}"/>
                                            </div>
                                            <div class="text-center mr-2">
                                                <img
                                                    data-toggle="tooltip"
                                                    title="{{ $reader->name }}"
                                                    data-placement="bottom"
                                                    class="reader_image"
                                                    src="{{ $reader->avatar}}"
                                                    alt="{{ $reader->name }}"/>
                                            </div>
                                            <div class="text-center mr-2">
                                                <img
                                                    data-toggle="tooltip"
                                                    title="{{ $reader->name }}"
                                                    data-placement="bottom"
                                                    class="reader_image"
                                                    src="{{ $reader->avatar}}"
                                                    alt="{{ $reader->name }}"/>
                                            </div>
                                            <div class="text-center mr-2">
                                                <img
                                                    data-toggle="tooltip"
                                                    title="{{ $reader->name }}"
                                                    data-placement="bottom"
                                                    class="reader_image"
                                                    src="{{ $reader->avatar}}"
                                                    alt="{{ $reader->name }}"/>
                                            </div> <div class="text-center mr-2">
                                                <img
                                                    data-toggle="tooltip"
                                                    title="{{ $reader->name }}"
                                                    data-placement="bottom"
                                                    class="reader_image"
                                                    src="{{ $reader->avatar}}"
                                                    alt="{{ $reader->name }}"/>
                                            </div>
                                            <div class="text-center mr-2">
                                                <img
                                                    data-toggle="tooltip"
                                                    title="{{ $reader->name }}"
                                                    data-placement="bottom"
                                                    class="reader_image"
                                                    src="{{ $reader->avatar}}"
                                                    alt="{{ $reader->name }}"/>
                                            </div>
                                             <div class="text-center mr-2">
                                                <div class 
                                                <img
                                                    data-toggle="tooltip"
                                                    title="{{ $reader->name }}"
                                                    data-placement="bottom"
                                                    class="reader_image"
                                                    src="{{ $reader->avatar}}"
                                                    alt="{{ $reader->name }}"/>
                                            </div>
                                            <div class="text-center mr-2">
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

                            <div class="mt-3">
                                <a class="w-full font-weight-bold" id="disableBookSuggestion" data-dismiss="modal" aria-label="Close" data-href= "{{ route('books.disableSuggestion') }}">
                                    <label class="c-pointer">
                                        <input type="checkbox" class="mr-1">Don't show me this again
                                    </label>
                                </a>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
