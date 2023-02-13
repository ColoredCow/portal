<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <p class="text-center align-middle">Previous Invoice Details</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(count($invoiceValue['allInstallmentPayments'])>0)
                    <div class="table-responsive">
                        <table class="table table-lg table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center align-middle">Last Payments</th>
                                    @if($invoiceValue['symbol']=='$')
                                        <th class="text-center align-middle">Bank Charges</th>
                                        <th class="text-center align-middle">Conversion Rate</th>
                                        <th class="text-center align-middle">Conversion Rate Diff</th>
                                    @endif
                                    <th class="text-center align-middle">Dates</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoiceValue['allInstallmentPayments'] as $key=> $item)
                                    <tr>
                                        <td class="text-center align-middle">{{ $item->amount_paid_till_now }} {{$invoiceValue['symbol']}}</td>
                                        @if($invoiceValue['symbol']=='$')
                                            <td class="text-center align-middle">{{ $item->bank_charges }} </td>
                                            <td class="text-center align-middle">{{ $item->conversion_rate }} </td>
                                            <td class="text-center align-middle">{{ $item->conversion_rate_diff }}</td>
                                        @endif
                                        <td class="text-center align-middle">{{ date('d-m-Y', strtotime($item->last_amount_paid_on)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center">No data available</p>
                @endif
            </div>
        </div>
    </div>
</div>
