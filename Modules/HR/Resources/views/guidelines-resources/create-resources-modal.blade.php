<div class="modal fade" id="create-Modal" tabindex="-1" aria-labelledby="createModal-Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModal-Label">Add Resouces</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('resources.create') }}" id="addResourceForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Resource URL<strong class="text-danger">*</strong></label>
                        <input type="url" class="form-control" id="resource_link" name="resource_link" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="category-type">Select Categories<strong class="text-danger">*</strong></label>
                        <select class="form-control" id="hrResourceCategory" name="hr_resource_category_id" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="job_id" id="job_id" value="{{$job->id}}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="addResourceForm" id="save-btn-action">Save</button>
            </div>
        </div>
    </div>
</div>