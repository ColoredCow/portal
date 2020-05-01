<div  id="nda_review_form">
    <div class="card ">
            <div class="card-header d-flex justify-content-between" data-toggle="collapse" data-target="#initiate_review_form" aria-expanded="false">
                <h5>Received from Client?</h5>
                <h5 class="text-theme-green-light">{{ $taskMetaData->get('status', 'Pending') }}</h5>
            </div>
        
            <div id="initiate_review_form">
                <div class="card-body" >
                    <div>
                        @if($ndaMeta->status == 'received-signed-copy')

                        <div>
                            We  have already uploaded the signed copy of the NDA <a href="{{ '/prospect/open-doc/1' }}"> here.</a> 
                            <br><br><br>
                        </div>
                        @endif


                        <form  id="approve_nda_form" action="{{  route('prospect.checklist.update', [$prospect, $checklistId]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="checklist_id" value="{{ $checklistId }}">
                            <input type="hidden" name="checklist_task_id" value="{{ 4 }}">
                            <input type="hidden" name="_action" value="received-nda-from-client">
                            <div class="custom-file mb-3 w-50p">
                                <input type="file" class="custom-file-input" id="received_nda_file" name="signed_nda_file" required="required">
                                <label class="custom-file-label" for="received_nda_file" >Choose file</label>
                            </div> <br>

                            <button type="submit" id="approveNDAFormButtonq"  class="btn btn-success">Upload signed copy</button> <br> <br>
                        </form>

                      
                        

                    </div>
                </div>
            </div>
    </div>
</div>


