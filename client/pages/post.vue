<template>
  <div class="container my-5">
    <div class="row d-flex justify-content-end">
      <div class="col-3">
        <button class="btn btn-sm btn-primary" @click="createForm()">Create</button>
      </div>
      <div class="col-5 d-flex justify-content-end">
        <div class="input-group input-group-sm mb-3 w-50">
          <input type="text" class="form-control" v-model="keyword" />
          <div class="input-group-append">
            <button type="submit" class="btn btn-primary">Search</button>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-4 px-3">
        <div class="card">
          <div class="card-header">
            <h5>Create</h5>
          </div>
          <div class="card-body">
            <form>
              <div class="form-group my-2">
                <label for="name">Name</label>
                <input type="text" class="form-control mt-2" id="name" />
                <small class="text-danger"></small>
              </div>
              <button class="btn btn-sm btn-primary" type="submit">Save</button>
            </form>
          </div>
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
            <tr>
              <td>1</td>
              <td>Aye Aye</td>
              <td></td>
              <td>PHP</td>
              <td>Lorem ipsum dolor</td>
              <td>
                <button class="btn btn-sm btn-success">Edit</button>
                <button class="btn btn-sm btn-danger">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style></style>
