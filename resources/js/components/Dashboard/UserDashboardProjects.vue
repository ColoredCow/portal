<template>
	<div class="card ">
		<div class=" d-flex justify-content-between card-header py-1 px-3">
			<h3 class="text-center">
				<a href="/projects?projects=my-projects">My projects</a>
			</h3>
			<h3 class="text-center">
				<a href="/projects">All projects</a>
			</h3>
		</div>
		<div class="card-body pt-3 h-360 w-389 overflow-y-scroll">
			<div v-if="this.projects.length > 0" class="list list-group unstyled-list">
				<div v-for="(project, index) in this.projects" :key="index">
					<div class="row">
						<div class="col-12 text-left d-flex align-items-center">
							<div class="w-300">
								<a :href="'/projects/' + project.id + '/show/'">{{ project.name }}</a>
								<span :class="project.velocity_color_class + ' font-weight-bold' + ' ml-2'">
									<a :href="'/projects/' + project.id + '/show/'" :class="project.velocity_color_class">
										<i class="mr-0.5 fa fa-external-link-square"> </i>
									</a>
									{{ project.velocity + ' (' + project.current_hours_for_month + ' Hrs.)' }}
								</span>
							</div>
						</div>
					</div>
					<hr class="mt-1">
				</div>
			</div>
			<div v-else>
				<p>Fetching latest data...</p>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: [],
	data() {
		return {
			projects: []
		};
	},

	methods: {
		async getProjects() {
			let response = await axios.get("/user/projects");
			this.projects = response.data;

		}
	},

	mounted() {
		this.getProjects();
	},

};


</script>
