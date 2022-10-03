<template>
  <div class="container my-5">
    <div class="row justify-content-end">
      <div class="col-2 offset-4">
        <button class="btn btn-primary mb-3" @click= "create">Create</button>
      </div>
      <div class="col-6">
        <form>
          <div class="input-group">
            <input type="text" placeholder="search" class="form-control" />
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
          <h4 class="card-header text-info">{{ isEditMode ? 'Edit': 'Create'}}</h4>
          <div class="card-body">
            <form method="POST" @submit.prevent= "create()">
              <div class="form-group">
                <label> Name:</label>
                <input v-model="category.name" type="text" class="form-control" />
              </div>
              <button type="submit" class="btn btn-primary">Save</button>
            </form>
          </div>
          <div class="footer"></div>
        </div>
      </div>
      <div class="col-8">
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody v-for="category in categories" :key="category.id">
            <tr>
              <td>{{ category.id }}</td>
              <td>{{ category.name }}</td>
              <td>
                <button class="btn btn-success btn-sm " @click= "edit(category)">Edit</button>
                <button class="btn btn-danger btn-sm" @click= "destroy(category.id)">Delete</button>
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
  data() {
    return {
      isEditMode: false,
      categories: [],
      category: {
        id: '',
        name: ''
      }
    };
},
 methods: {
    async create() {
        this.isEditMode = false;
        await this.$axios
        .$post("http://127.0.0.1:8000/api/category", { name: this.category.name })
        .then((res) => {
          this.categories.push(res);
          this.category.name = "";
        })
        .catch((err) => {
          console.log(err);
        });
    },
    async edit(category){
        this.isEditMode = true;
        this.category.id= category.id;
        this.category.name= category.name;
    },
    async update(){

    },
    async destroy(id){
        await this.$axios.$delete("http://127.0.0.1:8000/api/category/id")
        .then((res)=> this.fetch());  
}
  },
  async fetch() {
    this.categories = await fetch("http://127.0.0.1:8000/api/category").then((res) =>
      res.json()
    );
  },
};
</script>
