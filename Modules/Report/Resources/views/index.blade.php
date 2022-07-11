@extends('report::layouts.master')
@section('content')
<div class="container">
    <br>
    <div class="d-flex">
        <h4 class="d-inline-block font-weight-bold">Sales & Marketing Reports</h4>
        @can('report.edit')
        <button type="button" class="btn btn-primary ml-auto report" data-toggle="modal" data-target="#Modal">
            Add Report
        </button>
        <div class="modal @if(count($errors->all()) > 0) show-modal @endif" id="Modal" role="dialog" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Report</h4>
                        <button type="button" class="btn-close ml-auto" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('report.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ old('name') }}" required="required">
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
                                    <select name="type" id="type" class="form-control" required="required">
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
                                    <input type="url" name="embedded_url" class="form-control" id="embedded_url" placeholder="Embedded URL" value="{{ old('embedded_url') }}" required="required">
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
    @foreach($reports as $report)
    @if($report->type == "sales_and_marketing")
    <div class="card mt-4">
        <div class="card-header d-flex c-pointer" data-toggle="collapse" data-target="#report_id_{{ $report->id }}" aria-expanded="true" aria-controls="report-bar">
            <div>
                <h4 class="font-weight-bold"> {{ $report->name }} </h4>
            </div>
            <a href="{{ route('report.show', ['id' => $report->id]) }}" target="_self" class="btn btn-primary ml-auto"> View </a>
        </div>
        <div id="report_id_{{$report->id}}" class="collapse">
            <div class="card-body">
                <span class="font-weight-bold"> Description </span>
                <div> {{ $report->description }} </div>
            </div>
            @can('report.edit')
            <div class="card-footer">
                <a href="{{route('report.edit', ['id' => $report->id]) }}">
                    <button type="button" class="btn btn-primary report" data-toggle="modal" data-target="#EditModal"> Edit </button>
                </a>
            </div>
            @endcan
        </div>
    </div>
    @endif
    @endforeach
</div>
@endsection