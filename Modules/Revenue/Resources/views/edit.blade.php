<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="edit-revenue" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ route('revenue.update',['id' =>$revenue->id]) }}" method="Post">
            @csrf
            <div class="card-header">
                <span>Revenue Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{$revenue->name}}" required>
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="category" class="field-required">Category</label>
                        <input type="text" class="form-control" id="category" name="category" value="{{$revenue->category}}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="recieved_at">Date of Recieved</label>
                        <input type="date" class="form-control" id="recieved_at" name="recieved_at" value="{{$revenue->recieved_at}}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="currency" class="field-required">Currency</label>
                        <input type="text" class="form-control" id="currency" name="currency" value="{{$revenue->currency}}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="amount" class="field-required">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" value="{{$revenue->amount}}" required>
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="notes">Note</label>
                        <textarea type="text" class="form-control" value="{{$revenue->notes}}"></textarea>
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