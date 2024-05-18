@php
    $clientCountry = ($clientBillingAddress && $clientBillingAddress->id) ? $clientBillingAddress->country : null;
@endphp

<div class="card">
    <div id="">
        <div class="card-body">
            @if($clientCountry && $clientCountry->id)
            <input type="hidden" name="currency" value="{{ $clientCountry->currency }}">
            <div class="form-row">
                <div class="col-md-5 ">  
                    <div class="form-group ">
                        <label for="key_account_manager_id" class="field-required">Key Account manager</label>
                        <select name="key_account_manager_id" id="key_account_manager_id" class="form-control" required="required">
                            <option value="">Select key account manager</option>
                            @foreach ($keyAccountManagers as $status => $keyAccountManager)
                            <option {{ $keyAccountManager->id == $client->key_account_manager_id ? 'selected=selected' : '' }} value="{{ $keyAccountManager->id}}">{{ $keyAccountManager->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="service_rates">Service Rates</label>
                        <div class="d-flex justify-content-between">
                            <div class="input-group mr-5">
                                <input value="{{ $clientBillingDetail->service_rates }}" name="service_rates" type="number" step="0.01" class="form-control" placeholder="amount">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ $clientCountry->currency }}</span>
                                </div>
                              </div>

                            <select name="service_rate_term" class="form-control">
                                @foreach (config('client.service-rate-terms') as $serviceRateTerm)
                                    <option {{ $clientBillingDetail->service_rate_term == $serviceRateTerm['slug'] ? 'selected=selected' : '' }} value="{{ $serviceRateTerm['slug'] }}">{{ $serviceRateTerm['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="discount_rate">Discount</label>
                        <div class="d-flex justify-content-between">
                            <div class="input-group mr-5">
                                <input value="{{ $clientBillingDetail->discount_rate }}" name="discount_rate" type="number" step="0.01" class="form-control" placeholder="amount">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ $clientCountry->currency }}</span>
                                </div>
                            </div>
                            <select name="discount_rate_term" class="form-control">
                                <option {{ $clientBillingDetail->discount_rate_term == 'per_hour' ? 'selected=selected' : '' }} value="per_hour">Per Hour</option>
                                <option {{ $clientBillingDetail->discount_rate_term == 'overall' ? 'selected=selected' : '' }} value="overall">Overall</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 offset-md-1">  
                    <div class="form-group">
                        <label for="billing_frequency" >Billing Frequency</label>
                        <select name="billing_frequency" id="billing_frequency" class="form-control">
                            <option value="">Select billing frequency</option>
                            @foreach (config('client.billing-frequency') as $billingFrequency)
                            <option {{ $clientBillingDetail->billing_frequency == $billingFrequency['id'] ? 'selected=selected' : '' }} value="{{ $billingFrequency['id'] }}" data-value="{{ $billingFrequency['name'] }}">{{ $billingFrequency['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group dates @if($clientBillingDetail->billing_frequency == config('client.billing-frequency.net-15-days.id') || $clientBillingDetail->billing_frequency == config('client.billing-frequency.based-on-project-terms.id'))d-none @endif">
                        <label for="billing_date" >Billing Date <span data-toggle="tooltip" data-placement="right" title="If the selected date is greater then the number of days in the month then the available date before the selected date will be considered as billing date."><i class="fa fa-question-circle"></i>&nbsp;</span></label>
                        <div class="d-flex justify-content-between">
                            <div class="input-group mr-5 w-50p">
                                <select name="billing_date" id="billing_date" class="form-control">
                                    @for($monthDate=1; $monthDate<32; $monthDate++)
                                        <option {{ $clientBillingDetail->billing_date == $monthDate ?"selected=selected" : '' }} value="{{$monthDate}}">{{$monthDate}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
		            </div>
                    <div class="form-group">
                        <label for="bank_charges">Bank Charges</label>
                        <div class="d-flex justify-content-between">
                            <div class="input-group mr-5 w-50p">
                                <input value="{{ $clientBillingDetail->bank_charges }}" type="number" name="bank_charges" step="0.01" class="form-control" placeholder="amount">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ $clientCountry->currency }}</span>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
                <p>Please fill the billing address details first</p>
            @endif
        </div>
            @php
                $contractLevel = old('contract_level') ?? ($client->meta->first()->value ?? null);
                $checked = $contractLevel === 'client' ? 'checked' : '';
            @endphp

<div class="form-check-inline mr-0 form-group mt-1 ml-2">
    <input type="checkbox" class="checkbox-custom mb-1.9 mb-1.67 mr-3" style="margin-top: 10px" id="contract_level_checkbox" name="contract_level" value="client" {{$checked === 'checked' ? 'checked' : ''}}>

    <label class="form-check-label" for="contract_level_checkbox">Is this a client-level contract?
        <span data-toggle="tooltip" data-placement="right"
            title="Check if this client's all project works as client level"><i
                class="fa fa-question-circle"></i>&nbsp;</span></label>
</div>

            <div class="card-body" id="contract_fields" style="{{ $checked ? '' : 'display: none' }}">
            <div class="row">
                <div class="col-4">
                    Upload Contract:
                </div>
                <div class="col-3">
                    Start Date:
                </div>
                <div class="col-3"> 
                    End date:
                </div>
                
            </div>
            <div class="row mt-3" >
                <div class="col-4">
                    <div class="custom-file mb-3">
                        <input type="file" id="contract_file" name="contract_file" class="custom-file-input">
                        <label for="contract_file" class="custom-file-label overflow-hidden">Upload New
                            Contract</label>
                    </div>
                </div>
                <div class="col-3">
                    <input type="date" class="form-control" name="start_date" id="start_date" value= {{$client->clientContracts->first()->start_date ?? ''}}>
                </div>
                <div class="col-3">
                    <input type="date" class="form-control" name="end_date" id="end_date" value= {{$client->clientContracts->first()->end_date ?? ''}}>
                </div>
                
            </div>
            <div class="mt-3 mb-4">
                <span class="mb-3"  style="text-decoration: underline;" type="button" data-toggle="collapse" data-target="#contractHistory" aria-expanded="false" aria-controls="contractHistory">Contract History <i class="fa fa-arrow-down" aria-hidden="true"></i></span>
                <div class="collapse" id="contractHistory">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">File</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($client->clientContracts as $contract)
                            <tr>
                                <td>{{ basename($contract->contract_file_path) }}</td>
                                <td>{{ optional($contract->start_date)->format('d M Y') ?? '-' }}</td>
                                <td>{{ optional($contract->end_date)->format('d M Y') ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
        <div class="col-md-5">
            @can('finance.view')
            <div class="form-group">
                <a class="color-black text-decoration" href="{{ route('reports.finance.dashboard.client', ['client_id' => $client->billingDetails->client_id]) }}" style="color: black; text-decoration: underline;">
                    Revenue by Client
                    <i class="fa fa-bar-chart"></i>
                </a>
            </div> 
            @endcan
        </div>
        <div class="card-footer">
            @include('client::subviews.edit-client-form-submit-buttons')
        </div>
    </div>
</div>

<script>
    document.getElementById('contract_level_checkbox').addEventListener('change', function() {
        var cardBody = document.getElementById('contract_fields');
        if (this.checked) {
            cardBody.style.display = '';
        } else {
            cardBody.style.display = 'none';
        }
    });
</script>