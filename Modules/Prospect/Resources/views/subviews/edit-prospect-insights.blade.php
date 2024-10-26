<div class="card">
    <div class="card-body">
        <form action="{{ route('prospect.comment.update', [$prospect->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="comment" class="mb-4">Insights / Learning</label>
                <textarea name="comment" id="comment" class="form-control" rows="10"
                    placeholder="Enter your insights and learning here..." style="resize: vertical;"></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
</div>
