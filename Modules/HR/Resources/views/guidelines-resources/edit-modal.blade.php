<div class="modal fade" id="edit-Modal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Categories</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('resources.update', $resource )}}" id="update-form">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Resource Link</label>
                        <input type="text" class="form-control" id="resource_link" name="name" value="{{ $resource }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="category-type">Select Categories<strong class="text-danger">*</strong></label>
                        <select class="form-control" id="hrResourceCategory" name="category-type">
                            <option value="{{ $resource }}">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="update-form" id="save-btn-action">Update</button>
            </div>
        </div>
    </div>
</div>
