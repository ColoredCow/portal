<template>
    <div>
        <div class="form-row mb-4 ml-3">
            <div class="form-group col-md-12">
                <div class="row">
                    <div class="col-12">
                        <p class="font-weight-bold" style="font-size:20px;">Invoice Items:</p>
                        <div class="items">
                            <div>
                                <div class="row">
                                    <div class="col-3 font-weight-bold">Description</div>
                                    <div class="col-2 font-weight-bold">Hours</div>
                                    <div class="col-2 font-weight-bold">Rate (US $) </div>
                                    <div class="col-2 font-weight-bold">Cost (US $)</div>
                                </div>

                                <div class="row mt-2" v-for="(item, index) in this.invoiceItems" :key="item.id">
                                    <div class="col-3 font-weight-bold">
                                        <textarea class="w-75" rows="1" type="text"   v-model="item.description"  :name="'item['+ index+'][description]'"></textarea>
                                    </div>
                                    <div class="col-2 font-weight-bold">
                                        <input class="w-50 text-center" type="number" v-model="item.hours"  :name="'item['+ index+'][hours]'">
                                    </div>
                                    <div class="col-2 font-weight-bold">
                                        <input class="w-50 text-center" type="number" v-model="item.rate" :name="'item['+ index+'][rate]'">
                                    </div>
                                    <div class="col-2 font-weight-bold">
                                        <input class="w-50 text-center" type="number" :name="'item['+ index+'][cost]'" :value="calculateCost(item, index)">
                                    </div>

                                    <div class="col-2 font-weight-bold">
                                        <span style="cursor:pointer" class="text-danger" @click="removeInvoiceItem(index)"> - Remove</span>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-3 font-weight-bold">
                                    </div>
                                    <div class="col-2 font-weight-bold">
                                    </div>
                                    <div class="col-2 font-weight-bold">
                                    </div>
                                    <div class="col-2 font-weight-bold">
                                    </div>
                                    <div class="col-2 font-weight-bold">
                                        <span class="btn btn-info" @click="addNewInvoiceItem()">Add new Item</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        props: [],
        data() { 
            return { 
                invoiceItems:[{ id:0, description:''}]
        } },
        computed: {},
        methods: {
            addNewInvoiceItem: function() {
                this.invoiceItems.push({});
            },

            removeInvoiceItem: function(index) {
                this.invoiceItems.splice(index, 1);
            },

            calculateCost: function(item, index) {
                let cost = item.hours * item.rate;
                this.invoiceItems[index].cost = cost;
                return cost;
            }
        },
        mounted() {

        }
    }
</script>
