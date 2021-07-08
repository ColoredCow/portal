<div class="modal fade" id="followUp{{$followUp->id}}" tabindex="-1" role="dialog" aria-labelledby="followUp{{$followUp->id}}"
    aria-hidden="true" v-if="selectedAction == 'round'">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-block">
                    <h5 class="modal-title">Follow up feedback</h5>
                    <h6 class="text-secondary">{{ $applicationRound->application->applicant->name }} &mdash;
                        {{ $applicationRound->application->applicant->email }}</h6>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<div class="row">
            		<div class="col-12">
            			<label class="fz-14 leading-none text-secondary">Comments</label>
            			<div class="fz-16 leading-normal white-space-pre-line">{{ $followUp->comments }}</div>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</div>