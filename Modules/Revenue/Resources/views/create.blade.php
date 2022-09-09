<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="create-revenue" aria-labelledby="create-revenue" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ route('revenue.storeData') }}" method="Post">
            @csrf
            <div class="card-header">
                <span>Revenue Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="category" class="field-required">Category</label>
                        <input type="text" class="form-control" name="category" id="category" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="recieved_at">Date of Recieved</label>
                        <input type="date" class="form-control" name="recieved_at" id="recieved_at">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="currency" class="field-required">Currency</label>
                        <input type="text" class="form-control" name="currency" id="currency" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="amount" class="field-required">Amount</label>
                        <input type="number" class="form-control" name="amount" id="amount" required>
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="note">Note</label>
                        <textarea type="text" class="form-control" name="note" id="note"></textarea>
                    </div>          
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary" id="save-btn-action">Save</button>
            </div>    
        </form>
      </div>
    </div>
  </div>