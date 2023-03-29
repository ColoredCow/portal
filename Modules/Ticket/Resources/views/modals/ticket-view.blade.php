<div class="modal fade" id="modal-ticket-view" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ticket Details</h5>
                <a data-toggle="modal" class='c-pointer' data-target="#modal-ticket-edit"><i class="fa fa-pencil"></i>
                </a>
            </div>
            <div class="modal-body">
                <div class="form-row ">
                    <div class="form-group col-md-5 mb-5">
                        <label class="font-weight-bold ">Title :</label>
                        <span>Correct Velocity of team Member</span>
                    </div>
                    <div class="form-group offset-md-1 col-md-5 mb-5">
                        <label class="font-weight-bold  ">Status : </label>
                        <span>Closed</span>
                    </div>
                    @php
                        $priority = 'High';
                    @endphp
                    <div class="form-group col-md-5 mb-5">
                        <label class="font-weight-bold">Priority:</label>
                        <span style="color: {{ $priority === 'critical' || $priority === 'High' ? 'red' : 'black' }}">
                            {{ $priority }}
                        </span>
                    </div>
                    <div class="form-group offset-md-1 col-md-5 mb-5">
                        <label class="font-weight-bold ">Issue Type : </label>
                        <span class='text-danger'><i class="fa fa-bug"></i>Bug</span>
                    </div>
                    <div class="form-group col-md-5 mb-5">
                        <label class="font-weight-bold ">Raised On : </label>
                        <span>{{ now()->format('d-m-Y') }}</span>
                    </div>
                    <div class="form-group offset-md-1 col-md-5 mb-5">
                        <label class="font-weight-bold ">Raised By : </label>
                        <i class="fa fa-user-circle-o" data-toggle="tooltip"
                            title="{{ 'Gaurav chamoli' }}">{{ 'Gaurav Chamoli' }}</i>
                    </div>
                </div>
                <div class="d-flex-column ">
                    <label class="font-weight-bold  ">Description : </label>
                    <span>{{ 'Show Correct Velocity of Team Member' }}</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@include('ticket::modals.edit')
