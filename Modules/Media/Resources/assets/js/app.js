/**
 * Media Tags
 *
 */
$(window).on("load", function(){
	$("#preloader").removeClass("d-block").addClass(" d-none ");
});


if (document.getElementById("media_tag")) {
	const mediaForm = new Vue({
		el: "#media_tag",
		data: {
			tags: document.getElementById("tag_container").dataset
				.tags
				? JSON.parse(
					document.getElementById("tag_container").dataset.tags
				)
				: [],
			tagNameToChange: [],
			indexRoute:
				document.getElementById("tag_container").dataset.indexRoute || "",
			newtagName: "",
			newtagMode: ""
		},

		methods: {
			showEditMode: function (index) {
				this.tagNameToChange[index] = this.tags[index]["name"];
				this.$set(this.tags[index], "editMode", true);
			},

			updatetagName: function (index) {
				this.$set(
					this.tags[index],
					"name",
					this.tagNameToChange[index]
				);
				let tagID = this.tags[index]["id"];
				let route = `${this.indexRoute}/${tagID}`;
				axios.put(route, {
					name: this.tags[index]["name"]
				});
				this.$set(this.tags[index], "editMode", false);
				this.$toast.success("Updated tag for media");
			},

			deletetag: async function (index) {
				let confirmDelete = confirm("Are you sure ?");

				if (!confirmDelete) {
					return false;
				}

				let tagID = this.tags[index]["id"];
				let route = `${this.indexRoute}/${tagID}`;
				let response = await axios.delete(route);
				this.tags.splice(index, 1);
			},

			updateNewtagMode: function (mode) {
				if (mode != "add") {
					this.newtagName = "";
				}
				this.newtagMode = mode;
			},

			addNewtag: async function () {
				if (!this.newtagName) {
					alert("Please enter tag name");
					return false;
				}
				this.$toast.success("Tag for media added successfully");
				let route = `${this.indexRoute}`;
				let response = await axios.post(route, {
					name: this.newtagName
				});

				if (response.data && response.data.tag) {
					this.tags.unshift(response.data.tag);
				}

				this.newtagMode = "saved";
			}
		}
	});
}
