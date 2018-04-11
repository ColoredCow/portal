<template>
    <div>
        <div v-for="(item, index) in items">
            <invoice-project-sub-component
            :item="item"
            :client="client">
            </invoice-project-sub-component>
        </div>
        <button type="button" class="btn btn-info btn-sm mt-3" v-on:click="addProject">Add Project</button>
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
        },
        mounted() {
            console.log(this.billings);
        },
    }
</script>
