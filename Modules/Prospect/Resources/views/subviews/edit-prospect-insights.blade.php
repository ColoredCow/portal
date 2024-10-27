<div class="card">
    <div class="card-body">
        <form action="{{ route('prospect.insights.update', $prospect->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="insight_learning" class="mb-4">Insights / Learning</label>
                <textarea name="insight_learning" id="insight_learning" class="form-control" rows="10"
                    placeholder="Enter your insights and learning here..." style="resize: vertical;"></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
</div>
