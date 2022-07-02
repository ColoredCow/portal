<div class="card-body">
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="name" class="field-required">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter client name" required="required"
                value="{{ old('name') }}">
        </div>
        <div class="form-group offset-md-1 col-md-5">
            <label for="channel_partner_id" >Channel partner 
                <span data-toggle="tooltip" data-placement="right" title="If this client came via a channel partner then link that client from here."><i class="fa fa-question-circle"></i>&nbsp;</span>
            </label>
            <select name="channel_partner_id" id="channel_partner_id" class="form-control">
                <option value="">Select channel partner</option>
                @foreach ($channelPartners as $status => $channelPartner)
                    <option value="{{ $channelPartner->id}}" {{ (old('channel_partner_id') == $channelPartner->id) ? "selected" : "" }}>{{ $channelPartner->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <br>
    <div class="form-row">
            <div class=" col-md-5 ">
                <div class="form-check-inline mr-0 form-group">