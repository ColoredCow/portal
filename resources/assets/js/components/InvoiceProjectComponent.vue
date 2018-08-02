<template>
    <div class="mb-4">
        <div v-for="(item, index) in items">
            <invoice-project-sub-component
            :index="index"
            :item="item"
            :client="client"
            @remove="removeItem(index)">
            </invoice-project-sub-component>
        </div>
        <button type="button" class="btn btn-info btn-sm" v-on:click="addProject">Add Project</button>
    </div>
</template>

<script>
    import InvoiceProjectSubComponent from './InvoiceProjectSubComponent.vue';

    export default {
        props: ['billings', 'client'],
        data() {
            return {
                items: this.billings ? this.billings : []
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
