  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Tags</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form id="details">
            <div class="form-group">
                <label for="dropdown">Select Tags</label>
                <select id="choices-multiple" class="form-control"  name="tags[]" placeholder="Select Tags" multiple>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->media_tag_name }}">{{ $tag->media_tag_name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
        </div>
      </div>
    </div>
  </div>
