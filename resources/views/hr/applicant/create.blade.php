@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Applicant Details</div>
                <div class="card-body">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="applicant_name">Name</label>
                                <input type="text" class="form-control" id="applicant_name" name="applicant_name" placeholder="Applicant name" required="required">
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label for="applicant_applied_for">Applied for</label>
                                <input type="text" class="form-control" id="applicant_applied_for" name="applicant_applied_for" placeholder="Applied for" required="required">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="applicant_phone">Phone</label>
                                <input type="text" class="form-control" id="applicant_phone" name="applicant_phone" placeholder="Applicant email" required="required">
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label for="applicant_email">Email</label>
                                <input type="email" class="form-control" id="applicant_email" name="applicant_email" placeholder="Applicant email" required="required">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
