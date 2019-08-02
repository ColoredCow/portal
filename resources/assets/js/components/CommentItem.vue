<template>
    <div class="card">

        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <div>
                    <span class="font-weight-bold">{{ comment.user.name }}</span>  <span class="text-muted"> said on {{ comment.created_at }} </span>
                </div>
         
                <div class="d-flex justify-content-between">
                    <p class="c-pointer mx-3 " @click="enableEditMode()">Edit</p>
                    <p class="c-pointer">Delete</p>
                </div>
            </div>


        </div>

        <div class="card-body">
            <div>
                <div v-if="state == 'edit'">
                    <textarea v-model="comment.comment" class="form-control"> </textarea>
                    <button class="btn btn-sm btn-info float-right">Save</button>
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
        }
    }
</script>
