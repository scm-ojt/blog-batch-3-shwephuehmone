<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h3 class="text-info">Register</h3>
            <form @submit.prevent="register">
              <div class="form-group">
                <input
                  type="text"
                  v-model="form.name"
                  class="form-control"
                  placeholder="Name"
                />
              </div>
              <div class="form-group">
                <input
                  type="text"
                  v-model="form.email"
                  class="form-control"
                  placeholder="Email"
                />
              </div>
              <div class="form-group mt-3">
                <input
                  type="password"
                  v-model="form.password"
                  class="form-control"
                  placeholder="Password"
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
        _token: '',
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
          this.$auth.loginWith("laravelSanctum", { data: this.form });
          this.$router.push({
            path: "/",
          });
        });
      } catch (err) {
        console.log(err);
      }
    },
  },
};
</script>
