@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Mail Templates</h1>
    <br>
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="round_mail_subject">Subject</label>
                <input type="text" name="round_mail_subject" class="form-control">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="round_mail_body">Mail body:</label>
                    <textarea name="round_mail_body" rows="10" class="richeditor form-control" placeholder="Body"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <input type="hidden" name="type">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>    
@endsection
