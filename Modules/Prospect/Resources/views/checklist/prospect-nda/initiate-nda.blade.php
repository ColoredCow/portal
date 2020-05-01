@php 
$checklistTaskId =  2;
$taskMetaData = collect($metaData[$checklistTaskId] ?? []);
$ndaMeta = $metaData;
@endphp

<div  id="nda_proscess_form">
    <div class="card ">
        <form action="{{  route('prospect.checklist.update', [$prospect, $checklistId]) }}" method="POST">
            @csrf
            <input type="hidden" name="checklist_id" value="{{ $checklistId }}">
            <input type="hidden" name="checklist_task_id" value="{{ $checklistTaskId }}">
            <input type="hidden" name="status" value="{{ $taskMetaData->get('status', 'Complete')}}">
            <input type="hidden" name="_action" value="{{ $taskMetaData->get('_action', 'initiate')}}">
            <div class="card-header d-flex justify-content-between" data-toggle="collapse" data-target="#initiate_nda_form" aria-expanded="false">
                <h5>Initiate NDA</h5>
                <h5 class="text-theme-green-light">{{ $taskMetaData->get('status', 'Complete') }}</h5>
            </div>
        
            <div id="initiate_nda_form">
                <div class="card-body" >
                    <div class="form-row">
                        <div class=" col-md-5">
                            <div class="form-group">
                                <label for="name" class="field-required">Mail Template</label>
                                <select class="form-control" name="mail_template_id" id="">
                                    <option {{ $ndaMeta->mail_template_id == 1 ? 'selected=selected' : '' }} value="1"> Mail template 1 </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label for="name" class="field-required">NDA template</label>
                                    <div class="c-pointer" style="text-decoration: underline" >Add new template</div>
                                </div>
                          
                                <select v-model="template" class="form-control" name="nda_template_id" id="">
                                    @foreach($templates ?:[] as $template) 
                                    <option {{ $ndaMeta->nda_template_id == $template->id ? 'selected=selected' : '' }} value="{{ $template->id }}">{{ $template->title  }}</option>
                                    @endforeach
                                </select>
                                <div class="c-pointer text-right pt-1" style="text-decoration: underline" v-on:click="toggleNDAPreview()">See Preview</div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="name" class="field-required">Client Contacts</label>
                                @foreach ($prospect->contactPersons as $contactPerson)
                                    <div>

                                        @if(is_array(json_decode($ndaMeta->nda_contact_persons, true)) && !in_array($contactPerson->id, json_decode($ndaMeta->nda_contact_persons, true)))
                                            <input  type="checkbox" name="nda_contact_persons[]" value="{{ $contactPerson->id }}" >
                                        
                                        @else
                                            <input checked type="checkbox" name="nda_contact_persons[]" value="{{ $contactPerson->id }}" >
                                        @endif

                                        <span> {{ $contactPerson->name  }} <span class="text-muted">({{ $contactPerson->email }})</span></span>
                                    </div>
                                @endforeach
                            </div> 
                            <br>

                            <div class="form-group">
                                <label for="due_date" class="c-pointer field-required">Due Date</label>
                                    <input value={{  $ndaMeta->due_date ?: date('Y-m-d', strtotime("+7 day")) }}  class="form-control w-50p" type="date" id="due_date" name="due_date">
                                </label>
                            </div>
            
                            <div class="form-group">
                                <label for="should_send_reminder" class="c-pointer">
                                    Enable reminders for the client &nbsp; 
                                    <input type='hidden' value='0' name='should_send_reminder'>
                                    @if($ndaMeta->enable_reminder != '0' || $ndaMeta->enable_reminder == 1) 
                                    <input value='1' checked="checked" class="c-pointer" type="checkbox" id="should_send_reminder" name="should_send_reminder">
                                    @else
                                        <input value='1'  class="c-pointer" type="checkbox" id="should_send_reminder" name="should_send_reminder">
                                    @endif

                                    <div class="fz-14">(We will confirm with you before sending the email)</div>
                                </label>
                            </div>
                        </div>
            
                        <div class=" col-md-5 offset-md-1">
                            <div class="form-group">
                                <label for="reviewer_id" class="field-required">Reviewer</label>
                                <select class="form-control" name="reviewer_id" id="">
                                    @foreach(\Modules\User\Entities\User::all() as $reviewer)
                                    <option {{ $ndaMeta->approver_id == $reviewer->id ? 'selected=selected' : '' }}  value="{{ $reviewer->id }}">{{ $reviewer->name }}  </option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <div class="form-group ">
                                <label for="authorizer_id" class="d-flex">Assignee:
                                    <div class="ml-4">{{ optional($prospect->assignTo)->name }}</div>
                                </label>
                                <input type="hidden" name="authorizer_id" value="{{ optional($prospect->assignTo)->id }}">
                               
                            </div>
                        </div>
            
                    </div>
                </div>

                <div class="card-footer">
                    @if($ndaMeta->status != 'received-signed-copy')
                    <button type="submit" class="btn btn-primary">Initiate NDA Process</button>
                    @endif
                </div>
            </div>

            <div v-if="showNDAPrivew" >
                @include('prospect::checklist.prospect-nda.preview-nda')
            </div>
        </form>
    </div>
    

{{-- 
    <br><br><br>
    
    @includeWhen($ndaMeta->status == 'in-review' || $ndaMeta->status == 'review-approved' ||  $ndaMeta->status == 'received-signed-copy' , 'prospect::checklist.prospect-nda.review-nda')

    <br><br><br>
    
    @includeWhen($ndaMeta->status == 'review-approved' || $ndaMeta->status == 'received-signed-copy', 'prospect::checklist.prospect-nda.received-nda') 
--}}

    

</div>


@section('js_scripts')
<script>
new Vue({
    el:'#nda_proscess_form',

    data() {
        return {
            shouldEnableReminder: true,
            showNDAPrivew:false,
            nDAPriviewResume:'{{ route("legal-document.nda.template.preview") }}',
            previewPDFLink:'{{ route("legal-document.nda.template.preview") }}',
            authorizer:'{{ optional($prospect->assignTo)->id }}',
            authorizerName:'{{ optional($prospect->assignTo)->name }}',
            template: 1,

        }
    },

    computed: {
        routeData: function() {
            return {
                recipientResourceName: '{{ optional($prospect->assignTo)->name }}',
                company: '{{ $prospect->name }}',
                template_id: this.template,
            }
        }
    }, 

    methods: {
        toggleNDAPreview() {
            var queryString = Object.keys(this.routeData).map(k => `${encodeURIComponent(k)}=${encodeURIComponent(this.routeData[k])}`).join('&');

            this.nDAPriviewResume = this.previewPDFLink +  "?" + queryString
            this.showNDAPrivew = !this.showNDAPrivew;
        },

        onChange(event) {
            this.routeData.recipientResourceName = event.target.options[event.target.options.selectedIndex].text;
        }
        
    },

    mounted() {
     
    }
});

</script>

@endsection