<template>
    <div class="card">
        <div class="card-header p-1">
            <h3 class="text-center">
                <a href="/projects">Projects</a>
            </h3>
        </div>
        <div class="card-body pt-3" style="height: 21em;overflow: auto;">
           <h5>No Project yet.</h5>
        </div>
    </div>
</template>

<script>
    export default {
        props: [],
        data() {
            return {
                books:[]
            }
        },

        methods: {
            async getReadBooks() {
                let response = await axios.get('/user/read-books');
                this.books =  response.data;

            }
        },

        mounted() {
            //this.getReadBooks();
        }



    }


</script>
