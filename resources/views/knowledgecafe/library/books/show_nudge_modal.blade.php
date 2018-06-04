<div class="modal fade" 
    id="show_nudge_modal"
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="show_nudge_modal" 
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New book suggestion for you</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            @php
                $book = App\Models\KnowledgeCafe\Library\Book::first();
            @endphp

            <div class="modal-body">
                    <h1 class="mt-1 mb-4 mx-2">
                        {{ $book->title }}
                    </h1>

                    <div class="row">
                        <div class="col-6">
                            <div class="ml-1 mb-1">
                                <h4>Written by:</h4>
                                <span> {{ $book->author }} </span>
                            </div>
                        </div>
        
                        <div class="col-4 text-center">
                            <img src=" {{ $book->thumbnail }} " />
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="type" class="btn btn-light" data-dismiss="modal" aria-label="Close">Remind me later</button>
                <a href="{{ route('books.show', $book->id ) }}" class="btn btn-primary">See in library</a>
            </div>
        </div>
    </div>
</div>