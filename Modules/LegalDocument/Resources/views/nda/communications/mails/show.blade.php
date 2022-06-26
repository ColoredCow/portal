@extends('legaldocument::layouts.master')

@section('content')

<div class="container">
    <h4>Update template</h4> <br><br>
    <div class="card">
        <form action="{{ route('legal-document.nda.template.update', $template) }}" method="POST">
    
            {{ csrf_field() }}
    
            <input type="hidden" name="legal_document_id" value="1">
            <div class="card-header c-pointer min-h-46" data-toggle="collapse" data-target="#applicant_autoresponder" aria-expanded="true" aria-controls="applicant_autoresponder"></div>
            <div id="applicant_autoresponder" class="collapse show">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Template Name</label>
                                <input type="text" name="title" class="form-control" value="{{ $template->title }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="body"> Template body:</label>
                                <textarea name="body" rows="10" class="richeditor form-control" placeholder="Body">{{ $template->body  }}</textarea>
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