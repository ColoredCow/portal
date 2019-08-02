<template>
    <div class="card">

        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <div>
                    <span class="font-weight-bold">{{ comment.user.name }}</span>  <span class="text-muted"> said on {{ comment.created_at }} </span>
                </div>
         
                <div class="d-flex justify-content-between">
                    <p class="c-pointer mx-3 text-muted " @click="enableEditMode()"><i class="fa fa-lg fa-pencil-square-o"></i></p>
                    <p class="c-pointer mx-3 text-danger " @click="enableEditMode()"><i class="fa fa-lg fa-trash-o"></i></p>
                </div>
            </div>


        </div>

        <div class="card-body">
            <div>
                <div v-if="state == 'edit'">
                    <textarea v-model="comment.comment" class="form-control"> </textarea>
                    <span class="float-right">
                        <button class="btn btn-sm btn-success mt-2 mx-3" @click="updateComment()">Save</button>
                        <button class="btn btn-sm btn-secondary mt-2" @click="updateComment()">Cancel</button>
                    </span>

                </div>
                <div v-else>
                    <p>{{ comment.comment }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['comment', 'editable'],
        data() {
            return {
                state:'view'
            }
        },
        mounted() {
        },
        methods: {
            enableEditMode() {
                this.state = 'edit';
            },

            disableEditMode() {
                this.state = 'view';
            },

            async updateComment(){
                let response = await axios.put(`/comments/${this.comment.id}`, {comment:this.comment.comment});
                this.disableEditMode();
            }
        }
    }
</script>
