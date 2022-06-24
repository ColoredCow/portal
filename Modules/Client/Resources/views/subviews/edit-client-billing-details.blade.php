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
                                <option {{ $clientBillingDetail->service_rate_term == 'per_hour' ? 'selected=selected' : '' }} value="per_hour">Per Hour</option>
                                <option {{ $clientBillingDetail->service_rate_term == 'overall' ? 'selected=selected' : '' }} value="overall">Overall</option>
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
                    <div class="form-group dates">
                        <label for="billing_date" >Billing Date <span data-toggle="tooltip" data-placement="right" title="If the selected date is greater then the number of days in the month then the available date before the selected date will be considered as billing date."><i class="fa fa-question-circle"></i>&nbsp;</span></label>
                        <div class="d-flex justify-content-between">
                            <div class="input-group mr-5 w-50p">
                                <select name="billing_date" id="billing_date" class="form-control">
                                    @for($monthDate=1; $monthDate<32; $monthDate++)
                                        <option {{ $monthDate == 'billing_date' ?"selected=selected" : '' }} value="{{$monthDate}}">{{$monthDate}}</option>
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
        <div class="card-footer">
            @include('client::subviews.edit-client-form-submit-buttons', ['isNext' => false])
        </div>
    </div>
</div>