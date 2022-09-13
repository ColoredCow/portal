 <div class="modal fade text-left"  tabindex="-1" role="dialog" id="modalEdit" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Edit Revenue</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('revenue.proceeds.update','id')}}" method="POST">
                        @csrf
                        <div class="form-row">
                            <input value="{{route('revenue.proceeds.update','id')}}" type="hidden" class="hidden" aria-hidden="true" name="routePlaceHolder">
                            <div class="form-group col-md-5">
                                <label for="" class="field-required">Name</label>
                                <input type="text" class="form-control" required name="name">
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label for="" >Category</label>
                                <input type="text" class="form-control" name="category">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="">Date of Recieved</label>
                                <input type="date" class="form-control" name="recieved_at" >
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label for="" class="field-required">Currency</label>
                                <input type="text" class="form-control" name="currency"  required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="" class="field-required">Amount</label>
                                <input type="number" class="form-control" name="amount"  required>
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label for="">Note</label>
                                <input type="text" class="form-control" name="notes">
                            </div>          
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="save-btn-action">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
