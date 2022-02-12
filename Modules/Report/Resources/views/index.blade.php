@extends('report::layouts.master')
@section('content')
<div class="container" id="vueContainer">
    <br>
    <div class="d-flex">
        <h4 class="d-inline-block">Sales & Marketing Reports</h4>
        @can('report.edit')
        <button type="button" class="btn btn-primary ml-auto report" data-bs-toggle="modal" data-bs-target="#Modal">
            Add Report
        </button>
        <div class="modal @if(count($errors->all()) > 0) show-modal @endif" id="Modal" role="dialog" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Report</h4>
                        <button type="button" class="btn-close ml-auto" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('report.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ old('name') }}">
                                    <span class="text-danger">
                                        @error('name')
                                        <strong>{{ $message }}</strong>
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="textarea" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea name="desc" class="form-control" id="textarea" rows="3" placeholder="Description">{{ old('desc') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-sm-2 col-form-label">Type<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select name="type" id="type" class="form-control">
                                        <option value="">Select Type</option>
                                        <option value="sales_and_marketing" {{ old('type') == "sales_and_marketing" ? 'selected' : '' }}> {{ config('report.report_type.sales_and_marketing') }} </option>
                                    </select>
                                    <span class="text-danger">
                                        @error('type')
                                        <strong>{{ $message }}</strong>
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="embedded_url" class="col-sm-6 col-form-label">
                                    Embedded URL<span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-10">
                                    <input type="url" name="embedded_url" class="form-control" id="embedded_url" placeholder="Embedded URL" value="{{ old('embedded_url') }}">
                                    <span class="text-danger">
                                        @error('embedded_url')
                                        <strong>{{ $message }}</strong>
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary mr-auto">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
    <div class="card mt-3">
        <div class="card-header" data-toggle="collapse">
            <h4>Sales and Marketing Reports <span>(Coming soon...)</span></h4>
        </div>
    </div>
</div>

@endsection