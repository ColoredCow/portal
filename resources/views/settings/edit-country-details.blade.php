<div class="modal fade" id="countryEditFormModal{{$country->id}}" tabindex="-1" role="dialog" aria-labelledby="countryEditFormModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="countryEditFormModalLabel">Country Details</h5> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="country-edit modal-body">
            <form action="{{route('country.edit', $country->id) }}" method="POST" id="countryEditForm">    
        @csrf
        <div class="modal-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Country</label>
                <div class="col-sm-4">
                    <input type="text" id="name" name="name" class="form-control" placeholder="Country" value="{{ old('name', $country->name) }}">
                </div>
                <label class="col-sm-2 col-form-label">Initials</label>
                <div class="col-sm-4">
                    <input type="text" id ="initials" name="initials" class="form-control" placeholder="Initials" value="{{ old('initials', $country->initials) }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Currency</label>
                <div class="col-sm-4">
                    <input type="text" id ="currency" name="currency" class="form-control" placeholder="Currency" value="{{ old('currency', $country->currency) }}">
                </div>
                <label class="col-sm-2 col-form-label">Symbols</label>
                <div class="col-sm-4">
                    <select id="currency_symbol" name="currency_symbol" class="form-control">
                    @foreach(config('client.currency-symbols') as $key => $value)
                        <option value="{{ implode($value) }}" @if(old('currency_symbol', $country->currency_symbol) == implode($value)) selected @endif>{{implode($value)}}</option>
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
    </div>
</div>
