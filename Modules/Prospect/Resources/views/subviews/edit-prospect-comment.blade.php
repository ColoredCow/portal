<div class="card">
    <div class="card-body">
        <form action="{{ route('prospect.comment.update', [$prospect->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mt-3">
                <label for="comment">Comment</label>
                <textarea class="form-control" id="prospect_comment" name="prospect_comment" rows="3"
                    placeholder="Add your comment here"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
