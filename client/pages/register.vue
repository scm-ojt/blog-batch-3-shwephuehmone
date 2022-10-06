<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <img
              class="mx-auto d-block mb-3"
              src="https://media.istockphoto.com/photos/webinar-elearning-skills-business-internet-technology-concepts-picture-id1366428092?s=612x612"
              alt=""
              width="75"
              height="75"
            />
            <h3 class="text-info text-center">Sign Up</h3>
            <form @submit.prevent="register">
              <div class="form-group">
                <input
                  type="text"
                  v-model="form.name"
                  class="form-control"
                  placeholder="Name"
                  required
                />
              </div>
              <div class="form-group">
                <input
                  type="text"
                  v-model="form.email"
                  class="form-control"
                  placeholder="Email"
                  required
                />
              </div>
              <div class="form-group mt-3">
                <input
                  type="password"
                  v-model="form.password"
                  class="form-control"
                  placeholder="Password"
                  required
                />
              </div>
              <div class="form-group mt-3">
                <input
                  type="password"
                  v-model="form.password_confirmation"
                  class="form-control"
                  placeholder="Confirm Password"
                />
              </div>
              <button type="submit" class="btn btn-primary mt-3 btn-block">
                Register
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  auth: "guest",
  data() {
    return {
      form: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
        _token: "",
      },
      errors: [],
    };
  },
  mounted() {
    this.$axios.$get("/sanctum/csrf-cookie");
  },
  methods: {
    register() {
      try {
        this.$axios.post("/register", this.form).then((res) => {
          this.$router.push({
            path: "/login",
          });
        });
      } catch (err) {
        console.log(err);
      }
    },
  },
};
</script>
