<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div id="accordion" class="card-header accordion-button">
                    @if(count($invoiceValue['allInstallmentPayments'])>0)
                        @foreach ($invoiceValue['allInstallmentPayments']->sortByDesc('last_amount_paid_on') as $key=> $item)
                        <div class="card">
                            <div class="card-header" id="heading-{{$key}}">
                                <h5 class="mb-0">
                                <div data-toggle="collapse" data-target="#collapse-{{$key}}" aria-expanded="false" aria-controls="collapse-{{$key}}" data-parent="#accordion">
                                {{ "Paid " . $invoiceValue['allInstallmentPayments'][0]['amount_paid_till_now'] . $invoiceValue['symbol'] . " on " . date('d-m-Y', strtotime($invoiceValue['allInstallmentPayments'][0]['last_amount_paid_on']))}}
                                </div>
                                </h5>
                            </div>
                            <div id="collapse-{{$key}}" class="collapse" aria-labelledby="heading-{{$key}}" data-parent="#accordion">
                                <div class="card-body ">
                                    <div class="card text-center">
                                        <div class="card-header">
                                            <header class="nav nav-tabs card-header-tabs">Comments</header>
                                        </div>
                                        <div class="card-body text-justify">
                                            <p>{{ $item->comments }}</p>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-lg">
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
                                                <tr>
                                                    <td class="text-center align-middle">{{ $item->amount_paid_till_now }} {{$invoiceValue['symbol']}}</td>
                                                    @if($invoiceValue['symbol']=='$')
                                                    <td class="text-center align-middle">{{ $item->bank_charges }} </td>
                                                    <td class="text-center align-middle">{{ $item->conversion_rate }} </td>
                                                    <td class="text-center align-middle">{{ $item->conversion_rate_diff }}</td>
                                                    @endif
                                                    <td class="text-center align-middle">{{ date('d-m-Y', strtotime($item->last_amount_paid_on)) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                      <p>Data is not available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
