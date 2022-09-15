@extends('user::layouts.master')
@section('content')

<form action="{{route('user.store-roles')}}" method="POST">
    @csrf
    <div class="container pb-1 mr-6">
            <div class="card col-md-8">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <label for="name" class="field-required fz-14 leading-none text-secondary mb-1">Name</label>
                            <input type="text" class="form-control w-300" name="name" required="required">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="label" class="fz-14 leading-none text-secondary mb-1">Label</label>
                            <input type="text" class="form-control  w-300" name="label">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="guard_name" class="field-required fz-14 leading-none text-secondary mb-1">Guard Name</label>
                            <input type="text" class="form-control w-300" name="guard_name" required="required">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="description" class="field-required fz-14 leading-none text-secondary mb-1">Description</label>
                            <input type="text" class="form-control w-300" name="description" required="required">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div> 
</form> 
@endsection