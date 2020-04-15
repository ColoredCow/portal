<template>
    <span>
        <div v-for="(book, index) in this.books" :key="index">
            <div class="row" >
                <div class="col-2">
                    <div style="width: 30px;">
                        <img class="w-100" :src="book.thumbnail" alt="">
                    </div>
                
                </div>
                <div class="col-9 text-left d-flex align-items-center">
                    <a :href="'/knowledgecafe/library/books/'+ book.id ">{{ book.title }}</a>
                </div>
            </div>
            <hr class="mt-1">
        </div>
    </span>
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
            async getWishListBooks() {
                let response = await axios.get('/user/wishlist-books');
                this.books =  response.data;

            }
        },

        mounted() {
            this.getWishListBooks();
        }



    }


</script>
