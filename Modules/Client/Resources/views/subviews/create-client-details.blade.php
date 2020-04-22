<div class="card-body">
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="name" class="field-required">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter client name" required="required"
                value="{{ old('name') }}">
        </div>
        <div class="form-group offset-md-1 col-md-5">
            <label for="email" class="field-required">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter client email" required="required"
                value="{{ old('email') }}">
        </div>
    </div>
    <br>
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="key_account_manager_id" class="field-required">Key Account manager</label>
            <select name="key_account_manager_id" id="key_account_manager_id" class="form-control" required="required">
                <option value="">Select key account manager</option>
                @foreach ($keyAccountManagers as $status => $keyAccountManager)
                <option value="{{ $keyAccountManager->id}}">{{ $keyAccountManager->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group offset-md-1 col-md-5">
            <label for="name" class="field-required">Status</label>
            <select name="status" id="status" class="form-control" required="required">
                @foreach (config('client.status') as $status => $display_name)
                <option value="{{ $status }}">{{ $display_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <br>
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary">Create</button>
</div>