<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-4 offset-4">
        <form id="catForm" @submit.prevent="importExcel()">
          <b>Import Excel File:</b>
          <div>
            <span class="text-danger mb-3" v-for="(error,index) in errors" :key="index">*{{ error[0] }}<br></span>
            <input type="file" class="fileSelect mb-3" name="file" />
            <button type="submit" class="btn btn-success mb-3">Import
              <font-awesome-icon :icon="['fas', 'file-import']" />
            </button>
          </div>
        </form>
        <button class="btn btn-success mb-3" @click="exportExcel()">Download
          <font-awesome-icon :icon="['fas', 'download']" />
        </button>
        <button class="btn btn-primary mb-3" @click="create">
          Add
          <font-awesome-icon :icon="['fas', 'square-plus']" />
        </button>
      </div>
      <div class="col-3">
        <form @submit.prevent="search()">
          <div class="input-group">
            <input type="text" placeholder="search" class="form-control" v-model="keyword" />
            <div class="input-group-append">
              <button type="submit" class="btn btn-primary mb-3 justify-content-end">Search</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-4">
        <div class="card">
          <h4 class="card-header text-info">
            {{ isEditMode ? "Edit" : "Create" }}
          </h4>
          <div class="card-body">
            <form method="POST" @submit.prevent="create()">
              <div class="form-group">
                <label> Name:</label>
                <input v-model="category.name" type="text" class="form-control" />
              </div>
              <div class="text-danger mb-3" v-if="Error">{{ Error }}</div>
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
        <b-table id="my-table" small :fields="fields" :items="categories" :per-page="perPage"
          :current-page="currentPage">
          <template #cell(actions)="data">
            <button class="btn btn-success btn-sm" @click="edit(data.item)">

              <font-awesome-icon :icon="['fas', 'pen-to-square']" />
              Edit
            </button>
            <button class="btn btn-danger btn-sm" @click="destroy(data.item)">

              <font-awesome-icon :icon="['fas', 'trash']" />
              Delete
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
    title: "Category",
  },
  data() {
    return {
      perPage: 5,
      currentPage: 1,
      fields: [
        "id",
        { key: "id", label: "id" },
        "name",
        { key: "name", label: "name" },
        "Actions",
      ],
      isEditMode: false,
      category: {
        id: "",
        name: "",
      },
      categories: [],
      Error: "",
      errors: null,
      keyword: "",
    };
  },
  methods: {
    rows() {
      return this.categories.length;
    },
    search() {
      this.getCategories();
    },
    async getCategories() {
      await this.$axios
        .$get("http://127.0.0.1:8000/api/category?search=" + this.keyword)
        .then((res) => {
          this.categories = res;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    async create() {
      this.isEditMode = false;
      await this.$axios
        .$post("http://127.0.0.1:8000/api/category", this.category)
        .then(async (res) => {
          this.categories.unshift(res.data);
          this.category.name = "";
          await Toast.fire({
          icon: 'success',
          title: 'Created Successfully'})
        })
        .catch((error) => {
          this.Error = error.response.data.message;
        });
    },
    async edit(category) {
      this.isEditMode = true;
      this.category.id = category.id;
      this.category.name = category.name;
      this.Error = "";

      this.$axios
        .$put(`categories/${this.category.id}`, { name: this.category.name, id: this })
        .then(async (res) => {
          this.getCategories();
          this.category = {};
          await Toast.fire({
          icon: 'info',
          title: 'Updated Successfully'})
        })
        .catch((error) => {
          this.Error = error.response.data.message;
        });
    },
    async destroy(category) {
      if (confirm("Are you sure you want to delete?"))
        await this.$axios
          .delete(`http://127.0.0.1:8000/api/category/${category.id}`)
          .then(async () => {
            this.categories = this.categories.filter((item) => {
              return item.id !== category.id;
            });
            await Toast.fire({
          icon: 'warning',
          title: 'Deleted Successfully'})
        });
    },
    exportExcel() {
      this.$axios.$post("http://127.0.0.1:8000/api/category/export",
        { keyword: this.keyword },
        { responseType: "arraybuffer" })
        .then(async response => {
          const url = window.URL.createObjectURL(new Blob([response]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", "categories.xlsx");
          document.body.appendChild(link);
          link.click();
          await Toast.fire({
          icon: 'success',
          title: 'Downloaded Successfully'})
        });
    },
    importExcel() {
      var catForm = document.getElementById("catForm")
      var data = new FormData(catForm)
      this.$axios.$post("http://127.0.0.1:8000/api/category/import", data)
        .then(async (res) => {
          this.getCategories();
          await Toast.fire({
          icon: 'success',
          title: 'Imported Successfully'})
        }).catch((error) => {
          this.errors = error.response.data.errors;
          console.log();
        });
    },
  },
  async fetch() {
    this.categories = await fetch("http://127.0.0.1:8000/api/category").then((res) =>
      res.json()
    );
  },
  computed: {
    rows() {
      return this.categories.length;
    },
  },
};
</script>
