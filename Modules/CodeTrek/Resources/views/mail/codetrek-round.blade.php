<div>
	<style>
		.line {
			line-height: 1px;
		}
	</style>
	<p>Hello, {{$codetrekApplicant[0]['first_name'] }}</p>
	<p>We hope this email finds you well. We are delighted to inform you that you have successfully advanced to the current round of the internship selection process at ColoredCow. Congratulations on this outstanding achievement!</p>
    <p>The {{$applicationRound['round_name'] }} of the internship will provide you with an opportunity to delve deeper into the specific projects and tasks relevant to your field of interest.</p>
    <br>
	<p>Wishing you the best of luck in the {{$applicationRound['round_name'] }} of the internship!</p>
    <p class="line">Best regards,</p>
	<p class="line">ColoredCow</p>
</div>
