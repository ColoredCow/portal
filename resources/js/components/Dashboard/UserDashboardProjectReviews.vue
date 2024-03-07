<template>
  <div class="card text-center card text-center w-xl-389 h-xl-416">
    <div class="card-header p-1">
      <h3><a href="/knowledgecafe/library/books">Project Reviews</a></h3>
    </div>

    <div class="card-body pt-3 h-360 w-389 overflow-y-scroll">
        <div v-if="this.project_reviews.length > 0" class="list list-group unstyled-list">
            <div v-for="(project_review, index) in this.project_reviews" :key="index">
                <div class="row">
                    <div class="col-12 text-left d-flex align-items-center">
                        <div class="w-300">
                            <a :href="'/projects/' + project_review.id + '/show/'">{{ project_review.client.name }}</a>
                            <span :class="font-weight-bold + ' ml-2'">
                                {{ project_review.next_review_date }}
                            </span>
                        </div>
                    </div>
                </div>
                <hr class="mt-1">
            </div>
        </div>
        <div v-else>
            <p>Fetching latest data...</p>
        </div>
    </div>
  </div>
</template>

<script>
export default {
	props: [],
	data() {
		return {
			project_reviews: [],
		};
	},

	methods: {
		async getReadBooks() {
            console.log("Hell")
			let response = await axios.get("/user/reviews");
            console.log("hello",response)
			this.project_reviews = response.data;
		},
		setActiveTile(tile) {
			this.activeTile = tile;
			document.querySelector(".active").classList.remove("active");
			document.querySelector(`#${tile}`).classList.add("active");
		},
	},

	mounted() {
		this.getReadBooks();
	},
};
</script>
