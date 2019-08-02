<template>
    <div>
        <div class="mx-5">
            <div class="mb-3" v-for="(comment, index) in all_comments" v-bind:key="index">
                <comment 
                    @deleteComment="deleteComment" 
                    :book_index="index" 
                    :comment="comment" 
                    :editable="user.id == comment.user_id" ></comment>
            </div>

            <div class="mb-3">
                <h6 class="my-2">Want to share your thoughts?</h6>
                <textarea v-model="new_comment" class="form-control" rows="3" placeholder="Start writing ..."></textarea>
                <button class="btn btn-info float-right my-3 text-right" @click="addNewComment()">Comment</button>
            </div>
        </div>
    </div>
</template>



<script>
    export default {
        props: ['book', 'new_comment_route', 'book_comments', 'user'],
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
           },

           async deleteComment(data) {

               console.log(`${this.new_comment_route}/${data.comment.id}`);
                let response = await axios.delete(`${this.new_comment_route}/${data.comment.id}`);
                this.all_comments.splice(data.index, 1);   
           },
        }
    }
</script>
