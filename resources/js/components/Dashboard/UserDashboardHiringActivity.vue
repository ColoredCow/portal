<template>
  <div class="card text-center card text-center w-xl-389 h-xl-416">
    <div class="card-header p-1">
	    <h3><a href="/hr/recruitment/job">Job Applications</a></h3>
    </div>
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs flex-nowrap">
        <li class="nav-item">
          <a
            id="last-week"
            class="nav-link active c-pointer"
            @click="setActiveTile('last-week')"
            >Last week</a
          >
        </li>
        <li class="nav-item">
          <a 
            id="last-month" 
            class="nav-link c-pointer" 
            @click="setActiveTile('last-month')"
            >Last month</a
          >
        </li>

        <li class="nav-item">
          <a
            id="last-quarter"
            class="nav-link c-pointer"
            @click="setActiveTile('last-quarter')"
           >Last quarter</a
          >
        </li>
      </ul>
    </div>
    <div class="card-body pt-3 h-318 w-md-389 w-389 overflow-y-scroll">
      <div v-show="this.activeTile == 'last-week'">
        <user-dashboard-wishlist-books />
      </div>
      <span v-show="this.activeTile == 'last-month'">
        <user-dashboard-read-books />
      </span>
      <span v-show="this.activeTile == 'last-quarter'">
        COMING SOON
      </span>
    </div>
  </div>
</template>

<script>
export default {
	props: [],
	data() {
		return {
			activeTile: "wishlist",
		};
	},

	methods: {
		async getReadBooks() {
			let response = await axios.get("/user/read-books");
			this.books = response.data;
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

