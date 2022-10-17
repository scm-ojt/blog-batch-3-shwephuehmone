<template>
  <div class="container">
    <div class="card">
      <h4 class="card-header text-info">Edit Post</h4>
      <div class="card-body">
        <form method="POST" @submit.prevent="editPost()">
          <div class="form-floating">
            <label for="floatingSelect">Select Category:</label>
            <select
              name="category_id"
              multiple
              class="form-select"
              aria-label="Default select example"
            >
              <option
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
              >
                {{ category.name }}
              </option>
            </select>
          </div>
          Image:
          <b-form-file v-model="post.image" class="mt-3" plain></b-form-file>
          <div class="form-group mt-3">
            <label> Title:</label>
            <input v-model="post.title" type="text" class="form-control" />
          </div>
          <div class="text-danger mb-3" v-if="Error">*{{ Error.title }}</div>
          <div class="form-group">
            <label> Body:</label>
            <input v-model="post.body" type="text" class="form-control" />
          </div>
          <div class="text-danger mb-3" v-if="Error">*{{ Error.body }}</div>
          <div class="text-danger mb-3"></div>
          <button type="submit" class="btn btn-primary">
            Save
            <font-awesome-icon :icon="['fas', 'floppy-disk']" />
          </button>
        </form>
      </div>
      <div class="footer"></div>
    </div>
  </div>
</template>
<script>
export default {
  head: {
    title: "Post",
  },
  data() {
    return {
      Error: "",
      post: {},
      categories: [],
    };
  },
  mounted() {
    this.getCategories();
    this.getPost();
  },
  methods: {
    async getCategories() {
      await this.$axios
        .$get("http://127.0.0.1:8000/api/category")
        .then((res) => {
          this.categories = res;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    async getPost() {
      await this.$axios
        .$get("http://127.0.0.1:8000/api/post/" + this.$route.params.id)
        .then((res) => {
          this.post = res;
          console.log(this.post);
        });
    },
    editPost(id) {
      this.$axios
        .$post(`http://127.0.0.1:8000/api/post/${this.post.id}`, {
          image: this.post.image,
          title: this.post.title,
          body: this.post.body,
        })
        .then((res) => {
          this.$router
            .push({
              path: "/post",
            })
            .catch((error) => {
              this.Error = error.response.data.errors;
            });
        });
    },
  },
};
</script>
