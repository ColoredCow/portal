<div class="modal fade" id="select_appointment" tabindex="-1" role="dialog" aria-labelledby="select_appointment"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Enter details
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="selected_appointment_id" v-model="selected_appointment_id" value="">
                <div class="form-row">
                    <div class="form-group">
                        <label for="">Enter your email</label>
                        <input v-model="selected_email" type="email" required="required" class="form-control">
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="form-group col-md-12">
                        <button 
                            v-on:click="selectappointmentSlot"
                            type="button" class="btn btn-success px-4 round-submit"
                            data-action="confirm">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>