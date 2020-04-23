<div class="card">
    <div class="card-header" >
        <span>Client Details</span>
    </div>
    <div id="client_detail_form" class="collapse show" data-parent="#edit_client_form_container">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter client name" required="required"
                            value="{{ $client->name }}">
                    </div>
                    <div class="form-group col-md-5 offset-md-1">
                        <label for="key_account_manager_id" class="field-required">Key Account manager</label>
                        <select name="key_account_manager_id" id="key_account_manager_id" class="form-control" required="required">
                            <option value="">Select key account manager</option>
                            @foreach ($keyAccountManagers as $status => $keyAccountManager)
                            <option {{ ($keyAccountManager->id == $client->key_account_manager_id) ? 'selected=selected' : '' }} value="{{ $keyAccountManager->id}}">{{ $keyAccountManager->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Country</label>
                        <select name="country" id="country" class="form-control" required="required">
                            <option value="">Select country</option>
                            @foreach (config('client.countries') as $key => $country)
                            <option {{ ($country['name'] == $client->country) ? 'selected=selected' : '' }} value="{{ $country['name'] }}">{{ $country['display_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="email" >Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter client email" value="{{ $client->email }}">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" >State</label>
                        <input type="text" class="form-control" name="state" id="state" placeholder="Enter client state" value="{{ $client->state }}">   
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="phone" >Phone</label>
                        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter client phone"
                            value="{{ $client->phone }}">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="address" class="field-required">Address</label>
                        <textarea  class="form-control" name="address" id="address" placeholder="Client Address" required="required" >{{ $client->address }}</textarea>  
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="pincode" >Pincode</label>
                        <input type="text"  class="form-control" name="pincode" id="pincode" placeholder="Enter pincode"value="{{ $client->pincode }}"/> 
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
    </div>
   
</div>