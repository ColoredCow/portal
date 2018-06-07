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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-6 text-center">
                        <a href="{{ route('books.index', ['search'=> $book->title]) }}">
                            <img class="mb-1" src=" {{ $book->thumbnail }} " />
                        </a>
                        <p class="mb-1 font-weight-bold" > {{ $book->title }} </p>
                        <p class="mb-1" > {{ $book->author }} </p>
                    </div>

                    <div class="col-5">
                            <button type="button" 
                                data-id="{{$book->id}}" 
                                data-mark-book-route= "{{route('books.markBook')}}"
                                id="markBookAsRead" class="btn btn-primary m-2 w-100 py-2">Yes, I have read this
                            </button>
                            
                            <button type="button" 
                                data-id="{{$book->id}}" 
                                data-mark-book-route= "{{route('books.markBook')}}"
                                id="markBookAsRead" class="btn btn-info m-2 w-100 py-2">I wish to read it
                            </button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>