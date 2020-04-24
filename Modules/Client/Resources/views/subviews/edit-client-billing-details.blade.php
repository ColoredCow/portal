<div class="card">
    <div id="">
        {{-- <div class="card-body">
            <div class="form-row">
                <div class="col-md-5 ">
                    <div class="form-group ">
                        <label for="key_account_manager_id" class="field-required">Key Account manager</label>
                        <select name="key_account_manager_id" id="key_account_manager_id" class="form-control" required="required">
                            <option value="">Select key account manager</option>
                            @foreach ($keyAccountManagers as $status => $keyAccountManager)
                            <option value="{{ $keyAccountManager->id}}">{{ $keyAccountManager->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group ">
                        <label for="billing_contact" class="field-required">Billing Contact</label>
                        <select name="billing_contacts" id="billing_contacts" class="form-control" required="required" multiple="multiple">
                            <option value="">Select billing contacts</option>
                            @foreach ($client->contactPersons as $status => $contactPerson)
                            <option value="{{ $contactPerson->id}}">{{ $contactPerson->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group ">
                        <label for="billing_contact" class="field-required">Billing Address</label>
                        <select name="billing_contacts" id="billing_contacts" class="form-control" required="required">
                            <option value="">Select billing address</option>
                            @foreach ($client->contactPersons as $status => $contactPerson)
                            <option value="{{ $contactPerson->id}}">{{ $contactPerson->name }}</option>
                            @endforeach
                        </select>
                    </div>


                   
                </div>

         
                <div class=" col-md-5 offset-md-1">
                    @if($client->type == 'indian')
                        <div class="form-group">
                            <label for="name" >Client GST Number</label>
                            <input type="text" class="form-control" name="client_gst_number" id="client_gst_number" placeholder="Enter client gst number" value="{{ '' }}">   
                        </div>
                    @endif
                </div>
            
            </div>
        </div> --}}
        <div class="card-footer">
            @include('client::subviews.edit-client-form-submit-buttons', ['isNext' => false])
        </div>
    </div>
    


</div>