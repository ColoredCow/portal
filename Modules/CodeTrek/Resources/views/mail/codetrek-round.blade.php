<div>
	<style>
		.line {
			line-height: 1px;
		}
	</style>
	<p>Hi, {{$codetrekApplicant[0]['first_name'] }}</p>
	<p>This email is to notify you that the your round has been changed in codetrek.</p>
    <p>Applicant Name : {{$codetrekApplicant[0]->first_name }}</p>
    <p>Current Round : {{$applicationRound['round_name'] }}</p>
    <br>
    <p class="line">Thanks,</p>
	<p class="line">ColoredCow Portal</p>
</div>
