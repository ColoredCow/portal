<template>
    <div>
        <div v-for="(item, index) in items">
            <invoice-project-sub-component
            :index="index"
            :item="item"
            :client="client"
            :invoice="invoice"
            @remove="removeItem(index)">
            </invoice-project-sub-component>
        </div>
        <button type="button" class="btn btn-info btn-sm mt-3" v-on:click="addProject">Add Project</button>
    </div>
</template>

<script>
    import InvoiceProjectSubComponent from './InvoiceProjectSubComponent.vue';

    export default {
        props: ['billings', 'client', 'invoice'],
        data() {
            return {
                items: typeof this.billings !== typeof undefined ? this.billings : [],
            }
        },
        components: {
            'invoice-project-sub-component': InvoiceProjectSubComponent
        },
        methods: {
            addProject() {
                this.items.push({});
            },
            removeItem(index) {
                this.items.splice(index, 1);
                console.log(this.items);
            }
        }
    }
</script>
