<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-2 offset-4">
        <button class="btn btn-primary mb-3" @click="create">Create</button>
      </div>
      <div class="col-6">
        <form @submit.prevent="search()">
          <div class="input-group">
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
    </div>
    <div class="row">
      <div class="col-4">
        <div class="card">
          <h4 class="card-header text-info">{{ isEditMode ? "Edit" : "Create" }}</h4>
          <div class="card-body">
            <form method="POST" @submit.prevent="create()">
              <div class="form-group">
                <label> Name:</label>
                <input v-model="category.name" type="text" class="form-control" />
              </div>
              <div class="text-danger mb-3" v-if="Error">*{{ Error }}</div>
              <button type="submit" class="btn btn-primary">Save</button>
            </form>
          </div>
          <div class="footer"></div>
        </div>
      </div>
      <div class="col-8">
        <b-table
          id="my-table"
          small
          :fields="fields"
          :items="categories"
          :per-page="perPage"
          :current-page="currentPage"
        >
          <template #cell(actions)="data">
            <button class="btn btn-success btn-sm" @click="edit(data.item)">Edit</button>
            <button class="btn btn-danger btn-sm" @click="destroy(data.item)">
              Delete
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
        .$post("http://127.0.0.1:8000/api/category", { name: this.category.name })
        .then((res) => {
          this.categories.push(res);
          this.category.name = "";
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
        .$put(`categories/${this.category.id}`, { name: this.category.name })
        .then((res) => {
          this.getCategories();
          this.category = {};
        })
        .catch((error) => {
          this.Error = error.response.data.message;
        });
    },
    async destroy(category) {
      if (confirm("Are you sure you want to delete?"))
        await this.$axios
          .delete(`http://127.0.0.1:8000/api/category/${category.id}`)
          .then(() => {
            this.categories = this.categories.filter((item) => {
              return item.id !== category.id;
            });
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
