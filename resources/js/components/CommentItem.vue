<template>
    <div class="card">

        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <div class="mb-3">
                    <span class="font-weight-bold">{{ (editable) ? 'You' : comment.user.name }}</span>  <span class="text-muted"> said on {{ comment.created_at }} </span>
                </div>
         
                <div class="d-flex justify-content-between" v-if="editable">
                    <p class="c-pointer mx-3 text-muted " @click="enableEditMode()"><i class="fa fa-lg fa-pencil-square-o"></i></p>
                    <p class="c-pointer mx-3 text-danger " @click="deleteComment()"><i class="fa fa-lg fa-trash-o"></i></p>
                </div>
            </div>

        </div>

        <div class="card-body pt-3">
            <div>
                <div v-if="state == 'edit'">
                    <textarea v-model=comment.body class="form-control">{{comment.body}}</textarea>
                    <span class="float-right">
                        <button class="btn btn-sm btn-success mt-2 mx-3" @click="updateComment()">Save</button>
                        <button class="btn btn-sm btn-secondary mt-2" @click="disableEditMode()">Cancel</button>
                    </span>

                </div>
                <div v-else>
                    <p>{{ comment.body }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
	props: ["comment", "editable", "bookIndex"],
	data() {
		return {
			state:"view"
		};
	},
        
	methods: {
		enableEditMode() {
			this.state = "edit";
		},

		disableEditMode() {
			this.state = "view";
		},

		async updateComment(){
			let response = await axios.put(`/comments/${this.comment.id}`, {comment:this.comment.body});
			this.disableEditMode();
		},

		async deleteComment() {
			if(!confirm("Are you sure ?")) {
				return false;
			}

			let response = await axios.delete(`/comments/${this.comment.id}`);
			this.$emit("onDeleteComment", { index:this.bookIndex, comment:this.comment} );
		}
	}
};
</script>
