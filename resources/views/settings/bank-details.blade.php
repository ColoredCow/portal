@extends('layouts.app')
@section('content')
    <div class="container">
        <h4>Bank Details</h4>
        <br>
        <form action="{{ route('settings.bank-details.update') }}" method="POST">
            @csrf
            @include('status', ['errors' => $errors->all()])
            @includeWhen(session('success'), 'toast', ['message' => session('success')])
  <div class="card">
    <div id="BankDetails">
      @csrf
      <input type="hidden" value="bank_details" name="update_section">
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-5">
            <label for="AccNumber" class="field-required">Account Number</label>
            <input type="int" class="form-control" name="key[Accnumber]" id="AccNumber" required="required">
          </div>
          <div class="form-group offset-md-1 col-md-5">
            <label for="Bankname" class="field-required">Bank Address</label>
            <input type="text" class="form-control" name="key[bankaddress]" id="name" required="required">
          </div>
        </div>
        <br>
        <div class="form-row">
          <div class="form-group col-md-5">
            <label for="SwiftCode" class="field-required">Swift Code</label>
            <input type="int" class="form-control" name="key[SwiftCode]" id="SwiftCode" required="required">
          </div>
          <div class="form-group offset-md-1 col-md-5">
            <label for="ifciCode" class="field-required">IFCI Code</label>
            <input type="int" class="form-control" name="key[ifciCode]" id="ifciCode" required="required">
          </div>
        </div>
        <br>
        <div class="form-row">
          <div class="form-group col-md-5">
            <label for="PhoneNumber" class="field-required">Colored-Cow-Phone-Number</label>
            <input type="int" class="form-control" name="key[PhoneNumber]" id="PhoneNumber" required="required">
          </div>
          <div class="form-group offset-md-1 col-md-5">
            <label for="PANnumber" class="field-required">PAN Number</label>
            <input type="int" class="form-control" name="key[PANnumber]" id="PanNumber" required="required">
          </div>
        </div>
        <br>
        <div class="form-row">
          <div class="form-group col-md-5">
            <label for="Name" class="field-required">Correspondent-Bank</label>
            <input type="text" class="form-control" name="key[correspondentbankname]" id="name" required="required">
          </div>
          <div class="form-group offset-md-1 col-md-5">
            <label for="HSNCode" class="field-required">Correspondent-Bank-Swift-Code</label>
            <input type="int" class="form-control" name="key[corresbankswiftcode]" id="HSNNumber" required="required">
          </div>
        </div>
        <br>
        <div class="form-row">
          <div class="form-group col-md-5">
            <label for="GSTINnumber" class="field-required">GSTIN</label>
            <input type="int" class="form-control" name="key[GSTINnumber]" id="GSTINNumber" required="required">
          </div>
          <div class="form-group offset-md-1 col-md-5">
            <label for="HSNCode" class="field-required">HSN Code</label>
            <input type="int" class="form-control" name="key[HSNnumber]" id="HSNNumber" required="required">
          </div>
        </div>
        <br>
        <div class="form-row">
          <div class="form-group col-md-5">
            <label for="C-INnumber" class="field-required">Cin-No</label>
            <input type="int" class="form-control" name="key[CINnumber]" id="GSTINNumber" required="required">
          </div>
          <div class="form-group offset-md-1 col-md-5">
            <label for="name" class="field-required">Beneficiary-Bank-Of-USD</label>
            <input type="text" class="form-control" name="key[beneficiarybankofusd]" id="name" required="required">
          </div>
        </div>
      </div>
      <div class="card-footer">
      <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</form> 
@endsection