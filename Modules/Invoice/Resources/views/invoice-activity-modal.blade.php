<div class="modal fade bd-example-modal-lg" id="invoiceactivity{{$invoice->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Invoice Activity</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="modal-body">
                @foreach ($invoiceActivities as $activity )
                    @if ($activity->invoice_id == $invoice->id)
                    <?php
                        $richText = $activity->content;
                        $plainText = strip_tags($richText);
                    ?>

                    <div id="accordion">
                        <div class="card">
                          <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                              <button class="btn btn-link" data-toggle="collapse" data-target="#activityaccordion{{$activity->id}}" aria-expanded="true" aria-controls="collapseOne">
                                Reminder Sent On: {{ date(config('constants.display_date_format'), strtotime($activity->created_at)) }}
                              </button>
                            </h5>
                          </div>
                          <div id="activityaccordion{{$activity->id}}" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body text-justify">
                                <div class="d-flex justify-content-between w-full text-start">
                                    <div class="w-half"><b>To:</b> {{$activity->to}}</div>
                                    <div class="w-half"><b>From:</b> {{$activity->from}}</div>
                                </div>
                                <div class="d-flex justify-content-between mt-2 w-full text-start">
                                    <div class="w-half"><b>Receiver's Name:</b> {{$activity->receiver_name}}</div>
                                    <div class="w-half"><b>CC:</b> {{$activity->cc}}</div>
                                </div>
                                <div class="d-flex justify-content-between mt-2 w-full text-start">
                                    <div class="w-half"><b>Subject:</b> {{$activity->subject}}</div>
                                    <div class="w-half"><b>BCC:</b> {{$activity->bcc}}</div>
                                </div>
                                <div class="w-full mt-2">
                                    <div><b>Content:</b> {{$plainText}}</div>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        </div>
    </div>
</div>