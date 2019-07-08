<template>
    <div>
        <div class="card mx-5">
            <div class="card-body">
                <h6 class="my-2">Want to Share your thoughts? {{ book_id }}</h6>
                <textarea v-model="new_comment" class="form-control" rows="5" placeholder="start writing ..."></textarea>
                <button class="btn btn-info float-right mt-3 text-right" @click="addNewComment()">Comment</button>
            </div>
        </div>
    </div>
</template>



<script>
    export default {
        props: ['book', 'new_comment_route', 'comments'],
        data() {
            return {
               book_id:1,
               new_comment:''
               
            }
        },
        methods: {
           async addNewComment() {
                let response = await axios.post(this.new_comment_route, {comment:this.new_comment});
                this.comments.push({
                    user_id:response.user_id,
                    comment:response.comment
                });
           }
        }
    }
</script>
