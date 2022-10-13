<template>
  <div class="container">
    <div class="mt-4">
      <h4 class="text-info text-center">Post Details</h4>
      <b-card class="mb-3">
        <img class="img" :src="`http://localhost:8000/storage/images/${posts.image}`" />
        <center>
          <b-card-title class="text-secondary"> Title: {{ posts.title }} </b-card-title>
          <b-card-content class="text-mute">Content: {{ posts.body }}</b-card-content>
        </center>
        <div></div>
        <form @submit.prevent="saveComment()">
          <b-form-textarea
            id="textarea"
            v-model="text"
            placeholder="Comment here..."
            rows="3"
            max-rows="6"
            class="mt-4"
          >
          </b-form-textarea>

          <pre class="mt-3 mb-0">{{ text }}</pre>
        </form>
        <b-container class="mt-5">
          <b-button pill variant="outline-info" href="../post">
            <font-awesome-icon :icon="['fas', 'arrow-left']" /> Go Back
          </b-button>
          <b-button type="submit" pill variant="outline-success">
            <font-awesome-icon :icon="['fas', 'arrow-up']" /> Post
          </b-button>
          <b-button pill variant="outline-danger">
            <font-awesome-icon :icon="['fas', 'trash']" /> Delete
          </b-button>
        </b-container>
      </b-card>
    </div>
  </div>
</template>
<script>
//import axios from "axios";

export default {
  head: {
    title: "Post Details",
  },
  data() {
    return {
      posts: {},
      categories: [],
      commentData: {
        //user_id: {{ $auth.user.name }}
        //post_id: this.$route.params.id,
        body: "",
      },
      comments: [],
    };
  },
  mounted() {
    //this.getCategories();
    this.getPost();
  },
  methods: {
    async saveComment() {
      await this.$axios
        .$post("http://127.0.0.1:8000/api/comment", this.commentData)
        .then((res) => {
          //this.comments.push(res);
          console.log(res.data);
          this.commentData.body = "";
        });
    },
    async getPost() {
      await this.$axios
        .$get("http://127.0.0.1:8000/api/post/" + this.$route.params.id)
        .then((res) => {
          this.posts = res;
          console.log(this.post);
        });
    },
  },
};
</script>
<style>
.img {
  width: 80px;
  height: 80px;
  float: left;
}
</style>
