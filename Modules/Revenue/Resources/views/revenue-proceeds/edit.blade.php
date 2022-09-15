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
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group ml-6 col-md-5">
                                <input value="{{route('revenue.proceeds.update','id')}}" type="hidden" class="hidden" aria-hidden="true" name="routePlaceHolder">
                                <label for="" class="field-required">Name</label>
                                <input type="text" class="form-control" required name="name">
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label for="" class="field-required">Date of Recieved</label>
                                <input type="date" class="form-control" required name="recieved_at" >
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group ml-6 col-md-5">
                                <label for="" class="field-required">Category</label>
                                <select type="text" class="form-control" name="category" required>
                                    <option class="disabled">Select category</option>
                                    <option value="domestic">Domestic</option>
                                    <option value="export">Export</option>
                                    <option value="recieved-commission">Recieved Commission</option>
                                    <option value="cash-back">Cash Back</option>
                                    <option value="recieved-discount">Recieved Discount</option>
                                    <option value="interest-on-fd">Interest On FD</option>
                                    <option value="foreign-exchange-loss">Foreign Exchange Loss</option>
                                </select>
                            </div> 
                            <div class="form-group offset-md-1 col-md-5">
                                <label class="field-required">Year</label>
                                    <select type="text" class="form-control" name="year">
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group ml-6 col-md-5">
                                <label for="" class="field-required">Amount</label>
                                <div class="input-group">
                                    <div class=" input-group-prepend">
                                        <select name="currency" name="currency" class="input-group-text" required>
                                            <option value="INR">INR</option>
                                            <option value="USD">USD</option>
                                            <option value="CAD">CAD</option> 
                                        </select>
                                    </div>
                                  <input type="number" class="form-control" name="amount">
                                </div>
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label class="field-required">Month</label>
                                <select type="text" class="form-control" required name="month">
                                    <option class="disabled">Select Month</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">may</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">Augusst</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group ml-6 col-md-7">
                                <label for="">Note</label>
                                <textarea type="text" class="form-control" rows="3" name="notes"></textarea>
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
</div>
