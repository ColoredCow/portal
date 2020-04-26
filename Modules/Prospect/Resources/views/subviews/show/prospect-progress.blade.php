<div id="prospect_progress_view">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body min-h-40p">
                    <ul class="h-406 overflow-auto">
                        <li v-on:click="showHistoryDetails(index)" class="mb-3" v-for="(prospectHistory, index) in prospectHistories" :key="index">
                            <div class="font-weight-bold">
                                @{{ prospectHistory.performed_on  }}
                            </div>
                            <div>
                                <span>
                                    @{{ `${prospectHistory.performed_as} added by ${prospectHistory.performed_by}`  }}</span>
                            </div>

                            <div class="text-muted">
                                @{{ prospectHistory.description | str_limit(20) }}
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
           
        </div>

        <div class="col-md-8">
            <div class="card ">
                <div class="card-body w-70p min-h-40p">
                    <form method="POST" action="{{ route('prospect.history-store', $prospect) }}">
                        @csrf
                        <div class="form-group">
                            <textarea required="required" class="form-control" name="description" id="prospect_progress_description" placeholder="Start typing ....."  rows="6"></textarea>
                        </div>

                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                                <label for="" class="field-required">Select stage</label>
                                <span 
                                    class="c-pointer"
                                    style="text-decoration: underline" 
                                    data-toggle="modal" 
                                    data-target="#prospect_progress_new_stage_form"
                                    >Add new stage</span>
                            </div>
                            
                            <select class="form-control" name="prospect_stage_id" id="prospect_stage_id" required="required">
                                <option value=''>Select Stage</option>
                                <option  v-for="(progressStage, index) in this.progressStatges" :value="progressStage.id"> @{{ progressStage.name }}</option>
                            </select>
                        </div>

                        <div class="form-group text-right">
                            <button class="btn btn-info text-white">Save new progress</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('prospect::subviews.show.prospect-progress-stage-modal')
    @include('prospect::subviews.show.prospect-history-details-modal')
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
            selectedHistory:{}
        }
    },

    methods:{
        async saveNewStage() {
            if(!this.newStageName) {
                return false;
            }

            if(!confirm('Are you sure?')) {
                return;
            }

            let response = await axios.post("{{ route('prospect.new-stage') }}", {
                stageName: this.newStageName
            });

            let newStage =  response.data;
            this.progressStatges.push(newStage);
            this.newStageName = '';
            $('#prospect_progress_new_stage_form').modal('hide');
        },

        showHistoryDetails(index) {
            this.selectedHistory = this.prospectHistories[index];
            $('#prospect_history_details_modal').modal('show');
        }
    },

    mounted() {
      // alert("hello");
    }
});

</script>

@endsection