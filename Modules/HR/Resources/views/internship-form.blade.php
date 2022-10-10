@extends('report::layouts.finance')
@section('content')
<div class=" ml-15">
    <h1>Details:</h1>   
</div>
<br>
<form action="{{route('hr.updateInternFormDetails')}}" method="POST">
    @csrf
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="form-row mb-4">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="client_id" class="field-required">Name</label>
                            <select name="id" id="name_id" class="form-control" required="required">
                                <option value="">Select Name</option>
                                @foreach ($applicants as $applicant)
                                <option value="{{ $applicant->id }}">{{ $applicant->name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5 offset-md-1">
                        <div class="form-group">
                            <label for="contract_date_for_signing" class="field-required">Start Date</label>
                            <input type="date" class="form-control" name="start_date" id="start_date">
                        </div>
                        <div class="form-group">
                            <label for="contract_date_for_effective" class="field-required">End Date</label>
                            <input type="date" class="form-control" name="end_date" id="end_date">
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="container">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-success round-submit">Submit</button>
                    <button type="reset" value="Reset" class="btn btn-danger">Clear form</button>
                </div>
            </div>
        </div>
    </div> 
</form>
@endsection
