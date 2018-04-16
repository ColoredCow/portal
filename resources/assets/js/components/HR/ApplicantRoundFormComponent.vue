<template>
	<form :action="'/hr/applicants/rounds/' + applicantRound.id" method="POST" class="applicant-round-form">

	    <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="_token" :value="csrfToken">

	    <div class="card">
	        <div class="card-header d-flex align-items-center justify-content-between">
	            <div>
	                {{ applicantRound.round.name }}
	                <span :title="applicantRound.round.name + ' guide'" class="modal-toggler-text text-muted" data-toggle="modal" :data-target="'#round_guide_' + this.applicantRound.round.id">
	                    <i class="fa fa-info-circle fa-lg"></i>
	                </span>
	            </div>
	            <div class="d-flex align-items-center">
                    <div class="text-success" v-if="applicantRound.round_status == 'confirmed'"><i class="fa fa-check"></i>Accepted in this round</div>
                    <div class="text-danger" v-else-if="applicantRound.round_status == 'rejected'"><i class="fa fa-close"></i>Rejected</div>
                    <div class="ml-2 icon-pencil" v-if="!isActive" @click="editMode = !editMode"><i class="fa fa-pencil"></i></div>
	            </div>
	        </div>
	        <div class="card-body" v-show="editMode">
	            <div class="form-row">
	                <div class="form-group col-md-12">
	                    <label for="reviews[feedback]">Feedback</label>
	                    <textarea name="reviews[feedback]" id="reviews[feedback]" rows="6" class="form-control">{{ applicantReviewValue }}</textarea>
	                </div>
	            </div>
	        </div>
	        <div class="card-footer" v-show="editMode">

	        	<div v-if="!applicantRound.round_status">
		            <applicant-round-action-component
		            :rounds="unconductedApplicantRounds">
		            </applicant-round-action-component>
		            <button type="button" class="btn btn-outline-danger round-submit" data-status="rejected">Reject</button>
	        	</div>
	            <div class="d-flex align-items-center justify-content-between" v-else>
	                <div>
	                    <button type="button" class="btn btn-info round-update">Update</button>
                        <applicant-round-action-component
                        v-if="applicantRound.round_status == 'rejected'"
                        :rounds="unconductedApplicantRounds">
                        </applicant-round-action-component>
	                </div>
	                <div>
                        <span v-if="applicantRound.mail_sent" class="modal-toggler-text text-primary" data-toggle="modal" :data-target="'#round_mail_' + applicantRound.id">Mail sent for this round</span>
                        <button v-else type="button" class="btn btn-primary" data-toggle="modal" :data-target="'#round_' + applicantRound.id">Send mail</button>
	                </div>
	            </div>
	        </div>
	    </div>
	    <input type="hidden" name="round_status" :value="applicantRound.round_status">
	    <input type="hidden" name="next_round" value="0">
	    <input type="hidden" name="action_type" value="new">
	</form>
</template>

<script>
    import ApplicantRoundActionComponent from './ApplicantRoundActionComponent.vue';

    export default {
        props: ['applicantRound', 'unconductedApplicantRounds', 'applicantReviewValue', 'csrfToken', 'isActive'],
        data() {
            return {
            	editMode: this.isActive || false,
            }
        },
        components: {
            'applicant-round-action-component': ApplicantRoundActionComponent
        },
        mounted() {
        	console.log(this.applicantRound);
        }
    }
</script>
