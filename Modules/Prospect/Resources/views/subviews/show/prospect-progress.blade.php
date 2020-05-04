<div id="prospect_progress_view">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body min-h-40p">
                    <ul class="h-406 overflow-auto">
                        <li v-on:click="showHistoryDetails(index)" class="mb-3 c-pointer" v-for="(prospectHistory, index) in prospectHistories" :key="index">
                            <div class="font-weight-bold">
                                @{{ prospectHistory.performed_on  }}
                            </div>

                            <div class="" >
                                @{{ prospectHistory.description | str_limit(20) }}
                            </div>

                            <div class="font-italic text-black-50">
                                <span>
                                    @{{ `${prospectHistory.performed_as} added by ${prospectHistory.performed_by}`  }}
                                </span>
                            </div>

                        
                            <div class="text-muted" v-if="prospectHistory.documents.length" >
                                @{{ `${prospectHistory.documents.length} documents` }}
                            </div>

                            
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card ">
                <div class="d-flex w-full">
                    <div class="card-body w-60p min-h-40p">
                        <form method="POST" action="{{ route('prospect.history-store', $prospect) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <textarea required="required" class="form-control" name="description" id="prospect_progress_description" placeholder="Start typing ....."  rows="6"></textarea>
                            </div>
    
                        
                            <div class="form-group mt-5">
                                <div class="d-flex justify-content-between">
                                    <label for="" class="" >Upload document</label>
                                    <p style="text-decoration: underline" v-on:Click="addMoreDocument()">Add document</p>
                                </div>
                               
                                <div class="mb-2" v-for="(prospectDocument, index) in prospectDocuments" :key="prospectDocument.id">
                                    <div class="d-flex">
                                        <div class="custom-file mb-3">
                                            <input type="file" class="custom-file-input" :id="`customFile${index}`" name="prospect_documents[]">
                                            <label class="custom-file-label" :for="`customFile${index}`" >Choose file</label>
                                        </div>
    
                                        <span class="btn badge text-danger" v-if="prospectDocuments.length > 1" v-on:Click="removeDocument(index)" class="text-danger">Remove </span>

                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group  mt-10 d-flex justify-content-between">
                                <button type="submit" class="btn btn-info text-white ">Save new progress</button>
                                <button data-toggle="modal" data-target="#prospect_schedule_meeting_form" type="button" class="btn btn-success text-white">Schedule a meeting</button>
                            </div>
                        </form>
                    </div>

                    <div class="card-body w-40p min-h-40p">
                        @include('prospect::subviews.show.prospect-checklist')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('prospect::subviews.show.prospect-history-details-modal')
    @include('prospect::subviews.schedule-prospect-meeting')
</div>


@section('js_scripts')
<script>

new Vue({

    el:'#prospect_progress_view',

    data() {
        return {
            progressStatges:@json($prospectStages),
            test:'',
            newStageName:'',
            prospectHistories:@json($prospect->histories),
            selectedHistory:{},
            prospectDocuments:[]
        }
    },

    methods:{
        async saveNewStage() {
         
        },

        showHistoryDetails(index) {
            this.selectedHistory = this.prospectHistories[index];
            $('#prospect_history_details_modal').modal('show');
        },

        newDocument() {
            return {

                id: new Date().getTime(),
                temp:true,
                name:'',
            }
        },

        addMoreDocument() {
            this.prospectDocuments.push(this.newDocument());
        },

        removeDocument(index) {
            this.prospectDocuments.splice(index, 1);
        }
    },

    mounted() {
        this.addMoreDocument();
      // alert("hello");
    }
});

</script>

@endsection