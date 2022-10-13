<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-2 offset-4 mb-3">
        <b-button variant="primary" href="./posts/createpost">
          Add
          <font-awesome-icon :icon="['fas', 'square-plus']" />
        </b-button>
      </div>
      <div class="col-6">
        <form @submit.prevent="search()">
          <div class="input-group justify-content-end">
            <input
              type="text"
              placeholder="search"
              class="form-control"
              v-model="keyword"
            />
            <div class="input-group-append">
              <button type="submit" class="btn btn-primary">Search</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-8">
        <b-table
          id="my-table"
          small
          :fields="fields"
          :items="posts"
          :per-page="perPage"
          :current-page="currentPage"
        >
          <template #cell(image)="data">
            <img
              class="img"
              :src="`http://localhost:8000/storage/images/${data.item.image}`"
            />
          </template>
          <template #cell(actions)="data">
            <button class="btn btn-success btn-sm">
              <nuxt-link :to="`/posts/editpost/${data.item.id}`" class="text-white"
                >Edit</nuxt-link
              >
              <font-awesome-icon :icon="['fas', 'pen-to-square']" />
            </button>
            <button class="btn btn-danger btn-sm" @click="destroy(data.item)">
              Delete
              <font-awesome-icon :icon="['fas', 'trash']" />
            </button>
            <button class="btn btn-info">
              <nuxt-link :to="`./posts/${data.item.id}`" class="text-white"
                >Details</nuxt-link
              >
              <font-awesome-icon :icon="['fas', 'circle-info']" />
            </button>
          </template>
        </b-table>
        <div class="overflow-auto">
          <b-pagination
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            aria-controls="my-table"
          >
          </b-pagination>
          <p class="mt-3">Current Page: {{ currentPage }}</p>
        </div>
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
      perPage: 5,
      currentPage: 1,
      fields: [
        "id",
        { key: "id", label: "id" },
        "image",
        { key: "image", label: "image" },
        "title",
        { key: "title", label: "title" },
        "Actions",
      ],
      post: {
        id: null,
        //user_id: null,
        image: "",
        title: "",
      },
      posts: {},
      keyword: "",
    };
  },
  methods: {
    search() {
      this.getAllPosts();
    },
    // async getPost() {
    //   await this.$axios
    //     .$get("http://127.0.0.1:8000/api/post/?search=" + this.keyword)
    //     .then((res) => {
    //       this.post = res;
    //       console.log(this.post);
    //     });
    // },
    async getAllPosts() {
      await this.$axios
        .$get("http://127.0.0.1:8000/api/post?search=" + this.keyword)
        .then((res) => {
          this.posts = res;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    async destroy(post) {
      if (confirm("Are you sure you want to delete?"))
        await this.$axios.delete(`http://127.0.0.1:8000/api/post/${post.id}`).then(() => {
          this.posts = this.posts.filter((item) => {
            return item.id !== post.id;
          });
        });
    },
  },
  async fetch() {
    this.posts = await fetch("http://127.0.0.1:8000/api/post").then((res) => res.json());
  },
  computed: {
    rows() {
      return this.posts.length;
    },
  },
};
</script>

<style>
.img {
  width: 80px;
  height: 80px;
}
</style>
