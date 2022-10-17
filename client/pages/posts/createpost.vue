<template>
  <div class="container">
    <div class="card">
      <h4 class="card-header text-info">Create Post</h4>
      <div class="card-body">
        <form method="POST" @submit.prevent="store()">
          <div class="form-floating">
            <label for="floatingSelect">Select Category:</label>
            <select
              name="category[]"
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
          <div class="text-danger mb-3" v-if="Error">*{{ Error.image[0] }}</div>
          <div class="form-group mt-3">
            <label> Title:</label>
            <input v-model="post.title" type="text" class="form-control" />
          </div>
          <div class="text-danger mb-3" v-if="Error">*{{ Error.title[0] }}</div>
          <div class="form-group">
            <label> Body:</label>
            <input v-model="post.body" type="text" class="form-control" />
          </div>
          <div class="text-danger mb-3" v-if="Error">*{{ Error.body[0] }}</div>
          <div class="text-danger mb-3"></div>
          <button type="submit" class="btn btn-primary">
            Save
            <font-awesome-icon :icon="['fas', 'floppy-disk']" />
          </button>
          <b-button variant="danger" href="../post">
            Cancel <font-awesome-icon :icon="['fas', 'xmark']" />
          </b-button>
        </form>
      </div>
      <div class="footer"></div>
    </div>
  </div>
</template>
<script>
import swal from "sweetalert2";
export default {
  name: "postdetails",
  data() {
    return {
      post: {
        id: "",
        category: null,
        image: null,
        title: "",
        body: "",
      },
      posts: {},
      Error: "",
      categories: [],
    };
  },
  mounted() {
    this.getCategories();
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
    async store() {
      const formData = new FormData();
      formData.append("category", this.category);
      formData.append("image", this.post.image);
      formData.append("title", this.post.title);
      formData.append("body", this.post.body);
      this.$axios
        .post("http://127.0.0.1:8000/api/post", formData)
        .then((response) => {
          this.post = "";
          this.$router.push({
            path: "/post",
          });
        })
        .catch((error) => {
          this.Error = error.response.data.errors;
        });
    },
  },
};
</script>

<style></style>
