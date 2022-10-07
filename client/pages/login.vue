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
            <h3 class="text-info text-center mb-3">Please Sign In</h3>
            <form @submit.prevent="login()">
              <div class="form-group">
                <input
                  type="text"
                  v-model="form.email"
                  class="form-control"
                  placeholder="Email"
                />
              </div>
              <div class="text-danger mb-3" v-if="errors.email">
                *{{ errors.email[0] }}
              </div>
              <div class="form-group mt-3">
                <input
                  type="password"
                  v-model="form.password"
                  class="form-control"
                  placeholder="Password"
                />
                <div class="text-danger mb-3" v-if="errors.password">
                  *{{ errors.password[0] }}
                </div>
              </div>
              <button type="submit" class="btn btn-primary mt-3 btn-block">Login</button>
              <div class="text-xs">
                Not Registered?
                <nuxt-link class="text-blue-600" to="/register">Register</nuxt-link>
              </div>
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
        email: null,
        password: null,
      },
      errors: {},
    };
  },
  mounted() {
    this.$axios.$get("/sanctum/csrf-cookie");
  },
  methods: {
    async login() {
      this.message = null;
      this.errors = {};
      this.$nuxt.$loading.start();
      try {
        await this.$auth.loginWith("laravelSanctum", { data: this.form });
        await this.$router.push({
          path: "/category",
        });
      } catch (error) {
        console.log(error);
        this.errors = error.response.data.errors;
      }
      this.$nuxt.$loading.finish();
    },
  },
};
</script>
