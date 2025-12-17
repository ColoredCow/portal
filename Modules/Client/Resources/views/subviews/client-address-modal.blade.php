<div class="modal" id="myModalClientCountry">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Country Details</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="{{route("country.store")}}" method ="POST">    
        @csrf
        <div class="modal-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Country<strong class="text-danger">*</strong></label>
                <div class="col-sm-4">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Country" required>
                </div>
                <label class="col-sm-2 col-form-label">Initials<strong class="text-danger">*</strong></label>
                <div class="col-sm-4">
                    <input type="text" id ="initials" name="initials" class="form-control" placeholder="Initials" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Currency<strong class="text-danger">*</strong></label>
                <div class="col-sm-4">
                    <input type="text" id ="currency" name="currency" class="form-control" placeholder="Currency" required>
                </div>
                <label class="col-sm-2 col-form-label">Symbols</label>
                <div class="col-sm-4">
                    <select id="currency_symbol" name="currency_symbol" class="form-control">
                    @foreach(config('client.currency-symbols') as $key => $value)
                        <option value="{{ implode($value) }}">{{implode($value)}}</option>
                    @endforeach
                    </select>
                </div>
            </div>     
        </div>
            <div class="modal-footer">
                <input type="submit" class='btn btn-outline-primary' value="Save">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
