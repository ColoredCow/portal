<!-- Modal -->
<div class="modal fade text-left" id="createCrmConnectionModal" role="dialog" aria-labelledby="createCrmConnectionModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCrmConnectionModalTitle">{{ __('Add New Connection') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="prospectesId">{{ __('Prospectes*') }}</label>
                            <select name="prospectes_id" class="form-control" required id="prospectesId">
                                <option value="">Select Prospect</option>
                                @foreach($data['prospectes'] as $prospect)
                                    <option value="{{ $prospect->id }}">{{ $prospect->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_connected">{{ __('Last Connected*') }}</label>
                            <input type="date" class="form-control" placeholder="Last Connected" id="last_connected" name="last_connected" required>
                        </div>
                    </div>    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="status">{{ __('Status*') }}</label>
                            <select name="status" class="form-control" id="statuss">
                                <option value="">Select Status</option>
                                @foreach(config('crm.status-options') as $index => $status)
                                    <option value="{{ $index }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="source">{{ __('Source*') }}</label>
                            <input type="text" class="form-control" placeholder="Source" id="source" name="source" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="last_interaction">{{ __('Last Interaction') }}</label>
                            <input type="text" class="form-control" placeholder="Last Interaction" id="last_interaction" name="last_interaction" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="first_interaction">{{ __('First Interaction') }}</label>
                            <input type="text" class="form-control" placeholder="First Interaction" id="first_interaction" name="first_interaction" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="contact_name">{{ __('Contact Name*') }}</label>
                            <input type="name" class="form-control" placeholder="Contact Name" id="contact_name" name="contact_name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contact_email">{{ __('Contact Email*') }}</label>
                            <input type="email" class="form-control" placeholder="Contact Email" id="contact_email" name="contact_email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notes">{{ __('Notes') }}</label>
                        <textarea class="form-control" id="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"></i>{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
