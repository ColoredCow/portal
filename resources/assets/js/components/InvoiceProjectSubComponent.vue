<template>
    <div class="form-row row mt-3 d-flex align-items-center">
        <div class="form-group col-md-3">
            <label for="projects[]">Project</label>
            <select name="projects[]" class="form-control" v-model="projectId" v-on:change="updateStages">
                <option v-for="project in client.projects" :value="project.id" :selected="projectId == project.id">{{ project.name }}</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="stages[]">Stage</label>
            <select name="stages[]" class="form-control" v-model="stageId" v-on:change="updateBillings">
                <option v-for="stage in stages" :value="stage.id" :selected="stageId == stage.id">{{ stage.name }}</option>
            </select>
        </div>
        <div class="form-group col-md-2" v-if="editMode">
            <label for="billings[]">Billing%</label>
            <select name="billings[]" class="form-control">
                <option v-for="billing in billings" :value="billing.id" v-if="billing.finance_invoice_id" :selected="billingId == billing.id">{{ billing.percentage }}</option>
            </select>
        </div>
        <div class="form-group col-md-2" v-if="!editMode">
            <label for="billings[]">Billing%</label>
            <select name="billings[]" class="form-control">
                <option v-for="billing in billings" :value="billing.id" v-if="!billing.finance_invoice_id" :selected="billingId == billing.id">{{ billing.percentage }}</option>
            </select>
        </div>
        <div class="col-md-1">
            <span class="c-pointer text-danger" @click="$emit('remove', index)"><u>Remove</u></span>
        </div>
    </div>
</template>


<script>
    export default {
        props: ['index', 'item', 'client', 'editMode'],
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
            billingState: function(event){
                let hasBilling = true;
                if(!billing.finance_invoice_id){
                    hasBilling = false;
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
            }
        }
    }
</script>
