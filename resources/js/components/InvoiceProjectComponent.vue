<template>
    <div class="form-row row d-flex align-items-center">
        <div class="form-group col-md-3">
            <label>Project</label>
            <select class="form-control" v-model="projectId" v-on:change="updateActiveProject()">
                <option v-for="project in projects" :key="project.id">{{ project.name }}</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label>Stage</label>
            <select class="form-control" v-model="stageId" v-on:change="updateActiveStage()">
                <option v-for="stage in activeProject.stages" :key="stage.id">{{ stage.name }}</option>
            </select>
        </div>
        <div class="form-group col-md-2">
            <label>Billing</label>
            <select name="billings[]" class="form-control" v-model="billingId">
                <option v-for="stageBilling in activeStage.billings" :key="stageBilling.id">{{ stageBilling.percentage + '%' }} –  {{ client.currency }} {{ stageBilling.amount }}</option>
            </select>
        </div>
        <div class="col-md-1">
            <span class="c-pointer text-danger" v-on:click="$emit('remove')"><u>Remove</u></span>
        </div>
    </div>
</template>


<script>
export default {
	props: ["client", "billing"],
	watch: {
		client(newClient, oldClient) {
			this.projectId = this.billing && this.billing.hasOwnProperty("project_stage") ? this.billing.project_stage.project.id : newClient.projects[0].id;
			this.stageId = this.billing && this.billing.hasOwnProperty("project_stage") ? this.billing.project_stage.id : newClient.projects[0].stages[0].id;
			this.projects = newClient.projects;
			let firstTime = this.billing ? true : false;
			this.updateActiveProject(firstTime);
		}
	},
	data() {
		return {
			projects: this.client.projects,
			projectId: this.billing && this.billing.hasOwnProperty("project_stage") ? this.billing.project_stage.project.id : this.client.projects[0].id,
			stageId: this.billing && this.billing.hasOwnProperty("project_stage") ? this.billing.project_stage.id : this.client.projects[0].stages[0].id,
			billingId: this.billing && this.billing.hasOwnProperty("id") ? this.billing.id : this.client.projects[0].stages[0].billings[0].id,
			activeProject: this.client.projects[0],
			activeStage: this.client.projects[0].stages[0],
		};
	},
	methods: {
		updateActiveProject(firstTime = false) {
			for (let index in this.projects) {
				let project = this.projects[index];
				if (project.id == this.projectId) {
					this.activeProject = project;
					if (!firstTime) {
						this.stageId = this.activeProject.stages[0].id;
					}
					this.updateActiveStage(firstTime);
					break;
				}
			}
		},
		updateActiveStage(firstTime = false) {
			for (let index in this.activeProject.stages) {
				let stage = this.activeProject.stages[index];
				if (stage.id == this.stageId) {
					this.activeStage = stage;
					if (!firstTime) {
						this.billingId = this.activeStage.billings[0].id;
					}
					break;
				}
			}
		},
	},
	mounted() {
		let firstTime = this.billing ? true : false;
		this.updateActiveProject(firstTime);
	}
};
</script>
