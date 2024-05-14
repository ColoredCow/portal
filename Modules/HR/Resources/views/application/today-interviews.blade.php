<div>
	<?php if($todaysApplications) : ?>
		<div class="d-flex justify-content-start align-items-center">
			<?php foreach ( $jobCount as $jobTitle => $jobData ) : ?>
				<div class="rounded-pill w-fit bg-success fz-12" style="padding-left: 8px; padding-right: 8px; margin: 8px;">
					<span>{{ $jobTitle }} - {{ array_sum($jobData) }}</span>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="mt-5">
			<div class="border-success" style="border: 2px solid; border-radius: 50px; padding: 20px;">
				<?php foreach ( $todaysApplications as $key => $todayApplication ) : ?>
					<div class="d-flex justify-content-between align-items-center pt-5 pb-5" <?php echo $key != 0 ? 'style="border-top: 1px solid gray;"' : '' ?>>
						<div class="text-start">
							<p class="mb-0 fz-20"><i class="fa fa-user-circle-o fz-14 pr-1" aria-hidden="true"></i>{{ $todayApplication['application']['applicant']['name'] }}</p>
							<p class="mb-0 fz-16"><i class="fa fa-info-circle pr-1" aria-hidden="true"></i>{{ $todayApplication['application']['job']['title'] }}</p>
							<p class="mb-0 fz-16"><i class="fa fa-clock-o pr-1" aria-hidden="true"></i>{{ $todayApplication['meeting_time'] }}</p>
						</div>
						<div class="color-primary" style="padding-left: 8px; padding-right: 8px; margin: 8px;">
							<a target="_blank"
								class="ml-5 font-muli-bold text-decoration-none"
								href="{{ $todayApplication['meeting_link'] }}">
								<i class="fa fa-video-camera"
									aria-hidden="true"></i>
								<span>Meeting Link</span>
							</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php else : ?>
		<div class="d-flex justify-content-center mt-20 w-full">
			<div class="fz-36">
				<p>No Upcoming meetings for Today</p>
			</div>
		</div>
	<?php endif; ?>
</div>
