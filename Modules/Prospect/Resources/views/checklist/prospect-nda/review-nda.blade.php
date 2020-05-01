<div  id="nda_review_form">
    <div class="card ">
            <div class="card-header d-flex justify-content-between" data-toggle="collapse" data-target="#initiate_review_form" aria-expanded="false">
                <h5>Review NDA</h5>
                <h5 class="text-theme-green-light">{{ $ndaMeta->status  == 'review-approved' || $ndaMeta->status  == 'received-signed-copy' ? 'Complete' : 'Pending' }}</h5>
            </div>


            <div id="initiate_review_form">
                <div class="card-body" >
                    <div>
                        @if($ndaMeta->status == 'received-signed-copy')
                            <div>
                                NDA was appoved by {{  \Modules\User\Entities\User::find($ndaMeta->approver_id)->name }}
                            </div>
                        @else
                        <form  id="approve_nda_form" action="{{  route('prospect.checklist.update', [$prospect, $checklistId]) }}" method="POST" onsubmit="return confirm('Are you sure you want to review this nda and sent to client.')">
                            @csrf
                            <input type="hidden" name="checklist_id" value="{{ $checklistId }}">
                            <input type="hidden" name="checklist_task_id" value="{{ 3 }}">
                            <input type="hidden" name="_action" value="approve-nda">
                            <button type="submit" id="approveNDAFormButtonq"  class="btn btn-success"> Approve and send</button> <br> <br>
                        </form>
                        
                        <button class="btn btn-danger"> Reject NDA</button>
                        @endif


                    </div>
                    
                </div>
                </div>
            </div>
           
</div>


