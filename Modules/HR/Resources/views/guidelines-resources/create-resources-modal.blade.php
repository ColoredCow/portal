<div class="modal fade" id="create_Modal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Resouces</h5>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('resources.store') }}" id="create-form">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Resource URL<strong class="text-danger">*</strong></label>
                        <input type="url" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="category-type">Select Categories<strong class="text-danger">*</strong></label>
                        <select class="form-control" id="id" name="id" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" form="create-form" id="save-btn-action">Save</button>
            </div>
        </div>
    </div>
</div>