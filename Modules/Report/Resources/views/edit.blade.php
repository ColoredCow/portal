@extends('report::layouts.master')
@section('content')
<div class="container">
    <br>
    <div class="col-sm-10">
        <h4>Edit Report</h4>
    </div>
    <form method="post" action="{{ route('report.update', ['id' => $report->id]) }}">
        @csrf
        <div class="form-group">
            <label for="name" class="col-sm-4 col-form-label">Name<span class="text-danger">*</span></label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{$report->name}}">
                <span class="text-danger">
                    @error('name')
                    <strong>{{ $message }}</strong>
                    @enderror
                </span>
            </div>
        </div>
        <div class="form-group">
            <label for="textarea" class="col-sm-4 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea name="desc" class="form-control" id="textarea" rows="3" placeholder="Description">{{ $report->description }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="type" class="col-sm-4 col-form-label">Type<span class="text-danger">*</span></label>
            <div class="col-sm-10">
                <select name="type" id="type" class="form-control">
                    <option value="">Select Type</option>
                    <option value="sales_and_marketing" {{ $report->type == "sales_and_marketing" ? 'selected' : '' }}> {{ config('report.report_type.sales_and_marketing') }} </option>
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
                <input type="url" name="embedded_url" class="form-control" id="embedded_url" placeholder="Embedded URL" value="{{ $report->url }}">
                <span class="text-danger">
                    @error('embedded_url')
                    <strong>{{ $message }}</strong>
                    @enderror
                </span>
            </div>
        </div>
        <div class="form-group col-sm-10">
            <button type="submit" class="btn btn-primary mr-auto">Submit</button>
        </div>
    </form>
</div>
@endsection