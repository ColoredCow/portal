<template>
    <div class="form-row row mt-3">
        <div class="form-group col-md-3">
            <label for="projects[]">Project</label>
            <select name="projects[]" class="form-control" v-model="projectId" v-on:change="updateStages">
                <option v-for="project in client.projects" :value="project.id" :selected="projectId == project.id">{{ project.name }}</option>
            </select>
        </div>
        <div class="form-group offset-md-1 col-md-3">
            <label for="stages[]">Stage</label>
            <select name="stages[]" class="form-control" v-model="stageId" v-on:change="updateBillings">
                <option v-for="stage in stages" :value="stage.id" :selected="stageId == stage.id">{{ stage.name }}</option>
            </select>
        </div>
        <div class="form-group offset-md-1 col-md-3">
            <label for="billings[]">Billing</label>
            <select name="billings[]" class="form-control">
                <option v-for="billing in billings" :value="billing.id" :selected="billingId == billing.id">{{ billing.percentage }}</option>
            </select>
        </div>
    </div>
</template>


<script>
    export default {
        props: ['item', 'client'],
        data() {
            return {
                billingId: this.item.hasOwnProperty('id') ? this.item.id : [],
                stageId: this.item.hasOwnProperty('project_stage') ? this.item.project_stage.id : [],
                projectId: this.item.hasOwnProperty('project_stage') && this.item.project_stage.hasOwnProperty('project') ? this.item.project_stage.project.id : [],
            }
        },
        computed: {
            stages: function(event) {
                for (let index in this.client.projects) {
                    let project = this.client.projects[index];
                    if (project.id == this.projectId) {
                        return project.stages;
                    }
                }
            },
            billings: function(event) {
                for (let index in this.client.projects) {
                    let project = this.client.projects[index];
                    if (project.id == this.projectId) {
                        for (let count in project.stages) {
                            let stage = project.stages[count];
                            if (stage.id == this.stageId) {
                                return stage.billings;
                            }
                        }
                    }
                }
            }
        },
        methods: {
            updateStages(event) {
                this.stages = this.stages
                for(let i in this.stages) {
                    this.stageId = this.stages[i].id;
                    break;
                }
            },
            updateBillings(event) {
                this.billings = this.billings
                for(let i in this.billings) {
                    this.billingId = this.billings[i].id;
                    break;
                }
            },
        },
        mounted() {
            console.log(this.item);
        }
    }
</script>
