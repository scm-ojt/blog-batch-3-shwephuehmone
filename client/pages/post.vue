<template>
  <div class="container my-5">
    <form id="catForm">
          <b>Import Excel File:</b>
          <div>
            <input type="file" class="fileSelect mb-3" name="file" />
            <button type="submit" class="btn btn-success mb-3" @click="importExcel()">Import
              <font-awesome-icon :icon="['fas', 'file-import']" />
            </button>
          </div>
    </form>
    <div class="row">
      <button type="submit" class="btn btn-success mb-3" @click="exportExcel()">Download
        <font-awesome-icon :icon="['fas', 'download']" />
      </button>
      <div class="col-2 offset-4 mb-3">
        <b-button variant="primary" href="./posts/create">
          Add
          <font-awesome-icon :icon="['fas', 'square-plus']" />
        </b-button>
      </div>
      <div class="col-4">
        <form @submit.prevent="search()">
          <div class="input-group justify-content-end">
            <input type="text" placeholder="search" class="form-control" v-model="keyword" />
            <div class="input-group-append">
              <button type="submit" class="btn btn-primary">Search</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-8">
        <b-table id="my-table" small :fields="fields" :items="posts" :per-page="perPage" :current-page="currentPage">
          <template #cell(image)="data">
            <img class="img" :src="`http://localhost:8000/storage/images/${data.item.image}`" />
          </template>
          <template #cell(actions)="data">
            <button class="btn btn-success btn-sm">
              <nuxt-link :to="`/posts/editpost/${data.item.id}`" class="text-white">Edit</nuxt-link>
              <font-awesome-icon :icon="['fas', 'pen-to-square']" />
            </button>
            <button class="btn btn-danger btn-sm" @click="destroy(data.item)">
              Delete
              <font-awesome-icon :icon="['fas', 'trash']" />
            </button>
            <button class="btn btn-info">
              <nuxt-link :to="`./posts/${data.item.id}`" class="text-white">Details</nuxt-link>
              <font-awesome-icon :icon="['fas', 'circle-info']" />
            </button>
          </template>
        </b-table>
        <div class="overflow-auto">
          <b-pagination v-model="currentPage" :total-rows="rows" :per-page="perPage" aria-controls="my-table">
          </b-pagination>
          <p class="mt-3">Current Page: {{ currentPage }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2";
const Toast = Swal.mixin({
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
        "body",
        { key: "body", label: "body" },
        "Actions",
      ],
      post: {
        id: null,
        //user_id: null,
        image: "",
        comment: "",
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
      if (confirm("Are you sure you want to delete this post?"))
        await this.$axios.delete(`http://127.0.0.1:8000/api/post/${post.id}`).then(() => {
          this.posts = this.posts.filter((item) => {
            return item.id !== post.id;
          });
        });
    },
    importExcel(){
      var catForm = document.getElementById("catForm")
      var data = new FormData(catForm)
      this.$axios.$post("http://127.0.0.1:8000/api/post/import", data)
        .then((res) => {
          this.getAllPosts();
        }).catch((error) => {
          console.log(error);
        });
    },
    exportExcel() {
      this.$axios.$post("http://127.0.0.1:8000/api/post/export",
      { keyword: this.keyword },
      { responseType: "arraybuffer" })
        .then(response => {
          const url = window.URL.createObjectURL(new Blob([response]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", "posts.xlsx");
          document.body.appendChild(link);
          link.click();
          //console.log(response);
        //   await Toast.fire({
        //   icon: 'success',
        //   title: 'Downloaded Successfully'
        // })
        })
        // .catch((error) => {
        //   console.log(error);
        // });
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
  width: 100px;
  height: 100px;
  width: auto;
}
</style>
