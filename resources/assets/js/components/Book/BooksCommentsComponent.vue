<template>
    <div>
        <div class="mx-5">
            <div class="mb-3" v-for="(comment, index) in comments" v-bind:key="index">
                <comment 
                    @onDeleteComment="onDeleteComment" 
                    :book-index="index" 
                    :comment="comment" 
                    :editable="user.id == comment.user_id" ></comment>
            </div>

            <div class="mb-3">
                <h6 class="my-2">Want to share your thoughts?</h6>
                <textarea v-model="newComment" class="form-control" rows="3" placeholder="Start writing ..."></textarea>
                <button class="btn btn-info float-right my-3 text-right" @click="addNewComment()">Comment</button>
            </div>
        </div>
    </div>
</template>



<script>
    export default {
        props: ['book', 'newCommentRoute', 'bookComments', 'user'],
        data() {
            return {
               book_id:1,
               comments:[],
               newComment:''
            }
        },

        mounted() {
            this.comments = this.bookComments;
        },

        methods: {
           async addNewComment() {
                let response = await axios.post(this.newCommentRoute, {comment:this.newComment});
                this.newComment = '';
                this.comments.push(response.data);
           },

           async onDeleteComment(data) {
                this.comments.splice(data.index, 1);   
           },
        }
    }
</script>
