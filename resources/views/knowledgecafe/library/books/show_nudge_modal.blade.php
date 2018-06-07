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

            <div class="modal-body ml-5">
                <div class="row">
                    <div class="col-6">
                        <a class="shadow p-3 mb-5 bg-white rounded" href="{{ route('books.index', ['search'=> $book->title]) }}">
                            <img class="mb-1 mw-100" src=" {{ $book->thumbnail }} " />
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
                                data-dismiss="modal" 
                                data-id="{{$book->id}}" 
                                data-mark-book-route= "{{route('books.markBook')}}"
                                class="btn btn-info m-2 w-100 py-2">I wish to read it
                            </button>
                    </div>
                </div>

                @if($book->readers->count())
                    <div class="row" id="readers_section" >
                        <div class="col-8">
                                <div class="mb-1">
                                    <div class="d-flex justify-content-start"> 
                                        @foreach($book->readers as $reader)
                                            <div class="my-3 mr-3 ml-0 text-center">
                                                <img  
                                                    data-toggle="tooltip" 
                                                    title="{{ $reader->name }}"  
                                                    class="reader_image"
                                                    src="/images/default_profile.png"
                                                    alt="{{ $reader->name }}" 
                                                    data-placement="bottom" 
                                                />
                                            </div> 
                                        @endforeach
                                    </div>
                                </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>