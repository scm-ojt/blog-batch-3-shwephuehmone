<template>
  <div class="container">
    <div class="mt-4">
      <h4 class="text-info text-center">Post Details</h4>
      <b-card class="mb-3">
        <img class="img" :src="`http://localhost:8000/storage/images/${posts.image}`" />
        <center>
          <b-card-title class="text-secondary">Title: {{ posts.title }} </b-card-title>
          <b-card-body class="text-mute">Content: {{ posts.body }}</b-card-body>
        </center>
        <div class="form-floating mt-5">
          <label for="floatingTextarea2">Comments:</label>
          <textarea
            class="form-control mb-3"
            placeholder="Comment here..."
            id="floatingTextarea2"
            style="height: 100px"
            v-model="commentData.body"
          >
          </textarea>
          <b-button type="submit" variant="outline-success" @click="saveComment()">
           Save
           <font-awesome-icon :icon="['fas', 'floppy-disk']" />
          </b-button>
        </div>
        <div class="mt-3"><h5>Comments of posts:</h5></div>
        <div v-for="comment in comments" :key="comment.id">
          <p class="text-black">Written by: {{ $auth.user.name }}</p>
          <p class="text-black">Created at: {{ new Date(comment.created_at).toDateString() }}</p>
          <b-card-body class="text-secondary">
            {{ comment.body }}
            <b-button variant="outline-danger btn-sm" @click="removeComment(comment.id)">
              <font-awesome-icon :icon="['fas', 'trash']" />
            </b-button>
          </b-card-body>
        </div>
        <b-container class="mt-5">
          <b-button variant="outline-info" href="../post">
            <font-awesome-icon :icon="['fas', 'arrow-left']" />
            Back
          </b-button>
        </b-container>
      </b-card>
    </div>
  </div>
</template>
<script>
import swal from "sweetalert2";

const Toast = swal.mixin({
  toast: true,
  position: 'top-right',
  iconColor: '#a5dc86',
  customClass: {
    popup: 'colored-toast',
  },
  showConfirmButton: false,
  timer: 1500,
  timerProgressBar: true
})
export default {
  head: {
    title: "Post Details",
  },
  data() {
    return {
      posts: {
        user: {},
      },
      categories: [],
      commentData: {
        post_id: "",
        body: "",
      },
      comments: [],
    };
  },
  mounted() {
    this.getPost();
    this.showComments();
  },
  methods: {
    async saveComment() {
      await this.$axios
        .$post("http://127.0.0.1:8000/api/comment", this.commentData)
        .then((res) => {
          console.log(res.data);
          this.commentData.body = "";
        }).catch((err) => {
        console.error(err);
      });
    },
    async getPost() {
      await this.$axios
        .$get(`http://127.0.0.1:8000/api/post/${this.$route.params.id}`)
        .then((res) => {
          this.posts = res.posts;
          this.showComments();
        });
    },
    async showComments() {
      await this.$axios
        .$get(`http://127.0.0.1:8000/api/comment/${this.$route.params.id}`)
        .then((res) => {
          this.comments = res;
        })
      .catch((err) => {
        console.error(err);
      });
    },
    async removeComment(id) {
      if (confirm("Are you sure you want to delete this comment?"))
        await this.$axios
          .delete(`http://127.0.0.1:8000/api/comment/${id}`)
          .then(async (res) => {
            this.comments = this.comments.filter((item) => {
              return item.id !== id;
            });
            await Toast.fire({
            icon: 'warning',
            title: 'Deleted Successfully'
                          })
          });
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
