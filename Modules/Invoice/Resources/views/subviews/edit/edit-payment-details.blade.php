<div class="modal fade" id="editPaymentDetailsModal-{{$key}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Payment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('invoice.updatePaymentDetails', ['invoice' => $item->invoice_id, 'id' => $item->id, 'edit' => 'update-payment-details']) }}">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="amountPaid">Paid-Amount</label>
            <input type="text" class="form-control" id="amountPaid" name="amountPaid" value="{{$item->amount_paid_till_now}}">
          </div>
          @if($invoiceValue['symbol']=='$')
            <div class="form-group">
              <label for="bankCharges">Bank Charges</label>
              <input type="text" class="form-control" id="bankCharges" name="bankCharges" value="{{$item->bank_charges}}">
            </div>
            <div class="form-group">
              <label for="conversionRate">Conversion Rate</label>
              <input type="text" class="form-control" id="conversionRate" name="conversionRate" value="{{$item->conversion_rate}}">
            </div>
            <div class="form-group">
              <label for="ConversionRateDiff">Conversion_Rate_Diff</label>
              <input type="text" class="form-control" id="ConversionRateDiff" name="conversionRateDiff" value="{{$item->conversion_rate_diff}}">
            </div>
          @else
            <div class="form-group">
              <label for="tds">Tds</label>
              <input type="text" class="form-control" id="tds" name="tds" value="{{$item->tds}}">
            </div>
            <div class="form-group">
              <label for="tdsPercentage">Tds Percentage</label>
              <input type="text" class="form-control" id="tdsPercentage" name="tdsPercentage" value="{{$item->tds_percentage}}">
            </div>
          @endif
          <div class="form-group">
            <label for="comments">Comments</label>
            <textarea id="comments" name="comments" class="form-control">{{$item->comments}}</textarea>
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>
