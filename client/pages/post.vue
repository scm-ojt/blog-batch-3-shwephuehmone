<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-2 offset-4">
        <button class="btn btn-primary mb-3" @click="storepost()">
          Create<font-awesome-icon :icon="['fas', 'square-plus']" />
        </button>
      </div>
      <div class="col-6">
        <form @submit.prevent="search()">
          <div class="input-group">
            <input type="text" placeholder="search" class="form-control" />
            <div class="input-group-append">
              <button type="submit" class="btn btn-primary">Search</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-4">
        <div class="card">
          <h4 class="card-header text-info">Create</h4>
          <div class="card-body">
            <form method="POST">
              <div class="form-group">
                <label>Image</label>
                <input type="file" class="form-control" />
              </div>
              <div class="form-group">
                <label>Title</label>
                <input v-model="post.title" type="text" class="form-control" />
              </div>
              <div class="form-group">
                <label>Body</label>
                <input v-model="post.body" type="text" class="form-control" />
              </div>
              <button type="submit" class="btn btn-primary">
                Save
                <font-awesome-icon :icon="['fas', 'floppy-disk']" />
              </button>
            </form>
          </div>
          <div class="footer"></div>
        </div>
      </div>
      <div class="col-8">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>User Name</th>
              <th>Image</th>
              <th>Title</th>
              <th>Body</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="post in posts" :key="post.id">
              <td>{{ post.id }}</td>
              <!-- <td>{{ post.username }}</td> -->
              <td>{{ post.image }}</td>
              <td>{{ post.title }}</td>
              <td>{{ post.body }}</td>
              <td>
                <button class="btn btn-sm btn-success">
                  Edit
                  <font-awesome-icon :icon="['fas', 'pen-to-square']" />
                </button>
                <button class="btn btn-sm btn-danger">
                  Delete
                  <font-awesome-icon :icon="['fas', 'trash']" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
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
      post: {
        id: null,
        user_id: null,
        image: "",
        title: "",
        body: "",
      },
      posts: {},
    };
  },
  methods: {
    async storepost() {
      await this.$axios
        .$post("http://127.0.0.1:8000/api/category", { name: this.category.name })
        .then((res) => {
          this.categories.push(res);
          this.category.name = "";
        });
    },
  },
  async fetch() {
    this.categories = await fetch("http://127.0.0.1:8000/api/post").then((res) =>
      res.json()
    );
  },
};
</script>

<style></style>
