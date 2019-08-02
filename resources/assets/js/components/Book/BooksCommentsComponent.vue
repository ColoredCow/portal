<template>
    <div>
        <div class="mx-5">
            <div class="my-3" v-for="(comment, index) in all_comments" v-bind:key="index">
                <comment :comment="comment" :editable="false" ></comment>
            </div>

            <div class="card-body d-none">
                <h6 class="my-2">Want to share your thoughts?</h6>
                <textarea v-model="new_comment" class="form-control" rows="5" placeholder="start writing ..."></textarea>
                <button class="btn btn-info float-right mt-3 text-right" @click="addNewComment()">Comment</button>
            </div>
        </div>
    </div>
</template>



<script>
    export default {
        props: ['book', 'new_comment_route', 'book_comments'],
        data() {
            return {
               book_id:1,
               all_comments:[],
               new_comment:''
            }
        },

        mounted() {
            this.all_comments = this.book_comments;
        },

        methods: {
           async addNewComment() {
                let response = await axios.post(this.new_comment_route, {comment:this.new_comment});
                this.new_comment = '';
                this.all_comments.push(response.data);
           }
        }
    }
</script>
