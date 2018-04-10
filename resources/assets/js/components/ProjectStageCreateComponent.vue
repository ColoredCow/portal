<template>
    <div>
        <div v-for="(item, index) in items">
            <div class="card mt-4">
                <form action="/project/stages" method="POST">
                    <input type="hidden" name="_token" :value="csrfToken">
                    <input type="hidden" name="project_id" :value="projectId">
                    <div class="card-header">
                        New stage
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="name" class="field-required">Stage name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Stage name" required="required">
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label for="sent_amount">Stage cost</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <select name="currency_cost" id="currency_cost" class="btn btn-secondary" required="required">
                                            <option v-for="(currency_meta, currency) in currencies" :value="currency">
                                                {{ currency }}
                                            </option>
                                        </select>
                                    </div>
                                    <input type="number" class="form-control" name="cost" id="cost" placeholder="Stage cost" step=".01" min="0">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-3 d-flex align-items-center">
                                <input type="checkbox" name="cost_include_gst" id="cost_include_gst">
                                <label for="sent_amount" class="mb-0 pl-2">Is GST included in Stage Cost?</label>
                            </div>
                        </div>

                        <br>
                        <project-stage-billing-component
                        ref="billingComponent">
                        </project-stage-billing-component>

                        <button type="button" class="btn btn-info" v-on:click="addStageBilling">Add billing</button>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create stage</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import ProjectStageBillingComponent from './ProjectStageBillingComponent.vue';

    export default {
        props: ['currencies', 'csrfToken', 'projectId'],
        data() {
            return {
                items: []
            }
        },
        components: {
            'project-stage-billing-component': ProjectStageBillingComponent
        },
        methods: {
            create() {
                this.items.push({});
            },
            addStageBilling() {
                this.$refs.billingComponent[0].addBilling();
            },
        },
        mounted() {
        },
    }
</script>
