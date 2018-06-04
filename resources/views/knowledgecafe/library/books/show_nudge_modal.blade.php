<div class="modal fade" 
    id="show_nudge_modal"
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="show_nudge_modal" 
    aria-hidden="true"
    >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New book suggestion for you</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-6">

                        <div class="ml-1 mb-1 mt-2">
                            <h5 class="font-weight-normal">Title:</h5>
                            <span> {{ $book->title }} </span>
                        </div>

                        <div class="ml-1 mb-1 mt-2">
                            <h5 class="font-weight-normal" >Authors:</h5>
                            <span> {{ $book->author }} </span>
                        </div>

                        <div class="ml-1 mb-1 mt-2">
                            <h5 class="font-weight-normal">Categories:</h5>
                            <div>  
                                <ol class="pl-3">
                                    @foreach(($book->categories) ?: [] as $category)
                                        <li> {{$category->name}} </li>
                                    @endforeach
                                </ol> 
                            </div>
                        </div>
                            
                    </div>
    
                    <div class="col-4 text-center">
                        <img src=" {{ $book->thumbnail }} " />
                    </div>
                </div>
                
                <div class="row" id="readers_section" >
                    <div class="col-8">
                            <div class="ml-1 mb-1 mt-5">
                                <h4 v-if="readers.length">Read by:</h4>
                                <div class="d-flex justify-content-start"> 
                                    @foreach($book->readers as $reader)
                                        <div class="my-3 mr-3 ml-0 text-center">
                                            <img src="/images/default_profile.png" alt="">
                                            <h5> {{ $reader->name }} </h5>
                                        </div> 
                                    @endforeach
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">Remind me later</button>
                <button type="button" 
                    data-id="{{$book->id}}" 
                    data-mark-book-route= "{{route('books.markBook')}}"
                    id="markBookAsRead" class="btn btn-primary">I have read this</button>
            </div>
        </div>
    </div>
</div>