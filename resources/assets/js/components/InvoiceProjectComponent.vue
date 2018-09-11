<template>
    <div class="form-row row d-flex align-items-center">
        <div class="form-group col-md-3">
            <label>Project</label>
            <select class="form-control" v-model="projectId" v-on:change="updateActiveProject">
                <option v-for="project in projects" :value="project.id">{{ project.name }}</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label>Stage</label>
            <select class="form-control" v-model="stageId" v-on:change="updateActiveStage">
                <option v-for="stage in activeProject.stages" :value="stage.id">{{ stage.name }}</option>
            </select>
        </div>
        <div class="form-group col-md-2">
            <label>Billing%</label>
            <select name="billings[]" class="form-control" v-model="billingId">
                <option v-for="stageBilling in activeStage.billings" :value="stageBilling.id">{{ stageBilling.percentage }}</option>
            </select>
        </div>
        <!-- <div class="col-md-1">
            <span class="c-pointer text-danger"><u>Remove</u></span>
        </div> -->
    </div>
</template>


<script>
    export default {
        props: ['client', 'billing'],
        computed: {
            projects() {
                let projects = [];
                for (let i in this.client.projects) {
                    let project = this.client.projects[i];
                    let stages = [];
                    for (let j in project.stages) {
                        let stage = project.stages[j];
                        let billings = [];
                        for (let k in stage.billings) {
                            let billing = stage.billings[k];
                            if (this.billing && this.billing.id == billing.id) {
                                billings.push(billing);
                            }
                            if (!billing.invoice_id) {
                                billings.push(billing);
                                this.projectId = this.projectId || project.id;
                                this.stageId = this.stageId || stage.id;
                                this.billingId = this.billingId || billing.id;
                            }
                        }
                        if (billings.length) {
                            stages.push({
                                'id': stage.id,
                                'name': stage.name,
                                'billings': billings,
                            });
                        }
                    }
                    if (stages.length) {
                        projects.push({
                            'id': project.id,
                            'name': project.name,
                            'stages': stages
                        });
                    }
                }
                return projects;
            },
        },
        data() {
            return {
                projectId: null,
                stageId: null,
                billingId: this.billing ? this.billing.id : null,
                activeProject: this.projects,
                activeStage: this.projects,
            }
        },
        methods: {
            updateActiveProject() {
                for (let index in this.projects) {
                    let project = this.projects[index];
                    if (project.id == this.projectId) {
                        this.activeProject = project;
                        this.stageId = this.activeProject.stages[0].id;
                        break;
                    }
                }
                this.updateActiveStage();
            },
            updateActiveStage() {
                for (let index in this.activeProject.stages) {
                    let stage = this.activeProject.stages[index];
                    if (stage.id == this.stageId) {
                        this.activeStage = stage;
                        this.billingId = this.activeStage.billings[0].id;
                        break;
                    }
                }
            },
        },
        mounted() {
            this.updateActiveProject();
            this.updateActiveStage();
        }
    }
</script>
