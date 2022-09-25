<div class="modal fade" id="tagEditModal" tabindex="-1" role="dialog" aria-labelledby="tags" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tags">Edit Tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tagEditForm" action="{{ route('media.Tag.update', "id") }}" method="get">
                    @csrf
                    <div class="form-group">
                        <input value="{{ route('media.Tag.update', "id") }}" type="hidden" class="hidden" aria-hidden="true" name="routePlaceHolder"/>
                        <label for="tag">Enter Tag</label><strong class="text-danger">*</strong>
                        <input type="text" name="media_tag_name" class="form-control" id="tagName" >
                    </div><br>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
