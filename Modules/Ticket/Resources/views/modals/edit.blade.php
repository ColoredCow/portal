<div class="modal fade" tabindex="-1" id="modal-ticket-edit" value="">
    <div class="modal-dialog modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ticket Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div>
                <div class="modal-body">
                    <div class="form-row mb-4">
                        <div class="form-group col-md-5 mb-5">
                            <label class="font-weight-bold ">Title : </label>
                            <span>{{"Title of Issue"}}</span>
                            <span>
                                <a href="#" target="#"><i class="fa fa-github pl-1 fa-lg"></i></a>
                            </span>
                        </div>
                        <div class="form-group offset-md-1 col-md-5 mb-5">
                            <label class="font-weight-bold ">Status : </label>
                            <span>{{config('ticket.status.closed')}}</span>
                        </div>
                        @php
                            $priority = config('ticket.priority.high');
                        @endphp
                        <div class="form-group col-md-5 mb-5">
                            <label class="font-weight-bold">Priority:</label>
                            <span
                                style="color: {{ $priority === 'critical' || $priority === 'High' ? 'red' : 'black' }}">
                                {{ $priority }}
                            </span>
                        </div>
                        <div class="form-group offset-md-1 col-md-5 mb-5">
                            <label class="font-weight-bold">Issue Type : </label>
                            <span class='text-danger'><i class="fa fa-bug"></i>&nbsp{{config('ticket.type.bug')}}</span>
                        </div>
                        <div class="form-group col-md-5 mb-5">
                            <label class="font-weight-bold">Raised On : </label>
                            <span>{{ now()->format('d-m-Y') }}</span>
                        </div>
                        <div class="form-group offset-md-1 col-md-5 mb-5">
                            <label class="font-weight-bold">Raised By : </label>
                            <i class="fa fa-user-circle-o" data-toggle="tooltip"
                                title="{{ 'Creator Name' }}">&nbsp Creator Name</i>
                        </div>
                    </div>
                    <div class="d-flex-column ">
                        <label class="font-weight-bold">Description : </label>
                        <textarea id="description" class="form-control richeditor" name="description" rows="5"
                            value="Enter Issue description..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-block" onclick="#">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
