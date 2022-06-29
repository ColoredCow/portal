@extends('legaldocument::layouts.master')

@section('content')

<div class="container">
    <h4>Create new template</h4> <br><br>
    <div class="card mx-20">
        <form action="{{ route('legal-document.nda.template.store') }}" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="legal_document_id" value="1">

            <div class="card-header c-pointer min-h-46" data-toggle="collapse" data-target="#applicant_autoresponder" aria-expanded="true" aria-controls="applicant_autoresponder"></div>
            <div id="applicant_autoresponder" class="collapse show">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Template Name</label>
                                <input type="text" name="title" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="body"> Template body:</label>
                                <textarea name="body" rows="10" class="richeditor form-control" placeholder="Body"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


@endsection