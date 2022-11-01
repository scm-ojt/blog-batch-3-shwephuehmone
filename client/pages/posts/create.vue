<template>
  <div class="container">
    <div class="card">
      <h4 class="card-header text-info">Create Post</h4>
      <div class="card-body">
        <form method="POST" @submit.prevent="store()">
          <div class="form-floating">
            <label for="floatingSelect">Select Category:</label>
            <select v-model="post.category" name="category[]" multiple class="form-select">
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
          </div>
          <img  id="frame" alt="post image" width="100px" height="100px"/><br>
          Image:
          <b-form-file v-model="post.image" id="img" name="images" @change="preview" enctype="multipart/form-data" class="mt-3" plain>
          </b-form-file>
          <div class="text-danger mb-3" v-if="Error">*{{ Error.image[0] }}</div>
          <div class="form-group mt-3">
            <label> Title:</label>
            <input v-model="post.title" type="text" class="form-control" />
          </div>
          <div class="text-danger mb-3" v-if="Error">*{{ Error.title[0] }}</div>
          <div class="form-group">
            <label> Body:</label>
            <textarea v-model="post.body" type="text" class="form-control">
            </textarea>
          </div>
          <div class="text-danger mb-3" v-if="Error">*{{ Error.body[0] }}</div>
          <div class="text-danger mb-3"></div>
          <button type="submit" class="btn btn-primary">
            Save
            <font-awesome-icon :icon="['fas', 'floppy-disk']" />
          </button>
          <b-button variant="danger" href="../post">
            Cancel
            <font-awesome-icon :icon="['fas', 'xmark']" />
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
        category: [],
        image: null,
        title: "",
        body: "",
      },
      posts: {},
      url: "",
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
    preview(event) {
      let frame = document.getElementById("frame");
      frame.setAttribute("src", URL.createObjectURL(event.target.files[0]));
    },
    async store() {
      const formData = new FormData();
      formData.append("user_id",this.$auth.user.id);
      formData.append("categories", this.post.category);
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