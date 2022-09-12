<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Revenue</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('revenue.store')}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="" class="field-required">Name</label>
                        <input type="text" class="form-control" required name="name">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="" >Currency</label>
                        <input type="text" class="form-control" name="currency"  >
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="">Note</label>
                        <input type="text" class="form-control" >
                    </div>  
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="" class="field-required">Date of Recieved</label>
                        <input type="date" class="form-control" required name="recieved_at" >
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="" class="field-required">Amount</label>
                        <input type="number" class="form-control"  name="amount"  required>
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="" >Category</label>
                        <input type="text" class="form-control" name="category"  >
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="save-btn-action">Add</button>
            </div>
        </form>
      </div>
    </div>
  </div>
