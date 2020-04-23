<div class="card-body">
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="name" class="field-required">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter client name" required="required"
                value="{{ old('name') }}">
        </div>
        <div class="form-group col-md-5 offset-md-1">
            <label for="key_account_manager_id" class="field-required">Key Account manager</label>
            <select name="key_account_manager_id" id="key_account_manager_id" class="form-control" required="required">
                <option value="">Select key account manager</option>
                @foreach ($keyAccountManagers as $status => $keyAccountManager)
                <option value="{{ $keyAccountManager->id}}">{{ $keyAccountManager->name }}</option>
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
                <option value="{{ $country['name'] }}">{{ $country['display_name'] }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group offset-md-1 col-md-5">
            <label for="email" >Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter client email" value="{{ '' }}">
        </div>
    </div>
    <br>
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="name" >State</label>
            <input type="text" class="form-control" name="state" id="state" placeholder="Enter client state" value="{{ '' }}">   
        </div>
        <div class="form-group offset-md-1 col-md-5">
            <label for="phone" >Phone</label>
            <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter client phone"
                value="{{ '' }}">
        </div>
    </div>
    <br>
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="address" class="field-required">Address</label>
            <textarea  class="form-control" name="address" id="address" placeholder="Client Address" required="required" value="{{ '' }}"></textarea>  
        </div>
    </div>
    <br>
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="pincode" >Pincode</label>
            <input type="text"  class="form-control" name="pincode" id="pincode" placeholder="Enter pincode"value="{{ '' }}"/> 
        </div>
    </div>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary">Create</button>
</div>