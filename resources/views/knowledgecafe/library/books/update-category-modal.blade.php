<div class="modal fade" id="update_category_modal" tabindex="-1" role="dialog" aria-labelledby="update_category_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <ul class="list-group" >
                        @foreach($categories as $category)  
                            <li class="list-group-item">
                                <div class="form-check books_category_item">
                                    <label class="form-check-label">
                                    <input type="checkbox"  class="form-check-input book_category_input" value="{{ $category->id }}">{{ $category->name }}
                                    </label>
                                </div> 
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="modal-footer">
                <button type="type" class="btn btn-light" data-dismiss="modal" aria-label="Close">Cancel</button>
                <button type="button" type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
