<template>
    <div>
        <div v-for="(item, index) in items">
            <div class="card mt-4">
                <form :action="item.name ? '/project/stages/' + item.id : '/project/stages'" method="POST">
                    <input v-if="item.name" type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" :value="csrfToken">
                    <input type="hidden" name="project_id" :value="projectId">
                    <div class="card-header">
                        <div v-if="item.name" v-show="!editMode">{{ item.name }}</div>
                        <div class="form-group w-25 mb-0" v-show="editMode">
                            <div class="d-flex align-items-center">
                                <label for="name" class="mb-0">Name:&nbsp;</label>
                                <input type="text" class="form-control d-inline" name="name" id="name" placeholder="Stage name*" required="required" :value="item.name">
                            </div>
                        </div>
                        <div class="card-edit" @click="editMode = !editMode" v-show="!editMode"><i class="fa fa-pencil"></i></div>
                        <button type="submit" class="btn btn-primary card-edit" v-show="editMode">{{ item.name ? 'Update' : 'Create' }}</button>
                    </div>
                    <div class="card-body" v-show="editMode">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <label for="sent_amount" class="field-required">Cost</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select name="currency_cost" id="currency_cost" class="btn btn-secondary" required="required">
                                                    <option v-for="(currency_meta, currency) in currencies" :value="currency" :selected="currency == item.currency_cost">
                                                        {{ currency }}
                                                    </option>
                                                </select>
                                            </div>
                                            <input type="number" class="form-control" name="cost" id="cost" placeholder="Stage cost" step=".01" min="0" :value="item.cost" required="required" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-8 d-flex align-items-center">
                                        <input type="checkbox" name="cost_include_gst" id="cost_include_gst" :checked="item.cost_include_gst">
                                        <label for="sent_amount" class="mb-0 pl-2">Is GST included in Stage Cost?</label>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="col-md-6">
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <label for="name">Type</label>
                                        <select name="type" id="type" class="form-control" required="required">
                                            <option v-for="(displayName, type) in projectTypes" :value="type" :selected="type == item.type">
                                                {{ displayName }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label for="start_date">Start date</label>
                                        <input type="date" class="form-control" name="start_date" id="start_date" placeholder="dd/mm/yy" :value="item.start_date">
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label for="end_date">End date</label>
                                        <input type="date" class="form-control" name="end_date" id="end_date" placeholder="dd/mm/yy" :value="item.end_date">
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>

                        <project-stage-billing-component
                        :stage-billings="item.billings"
                        ref="billingComponent">
                        </project-stage-billing-component>

                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import ProjectStageBillingComponent from './ProjectStageBillingComponent.vue';

    export default {
        props: ['stages', 'currencies', 'csrfToken', 'projectId', 'projectTypes', 'dateFormat'],
        data() {
            return {
                items: this.stages ? this.stages : [],
                editMode: false,
            }
        },
        components: {
            'project-stage-billing-component': ProjectStageBillingComponent,
        },
        methods: {
            create() {
                this.items.push({
                    name: ''
                });
            },
            addStageBilling() {
                this.$refs.billingComponent[0].addBilling();
            },
        }
    }
</script>
