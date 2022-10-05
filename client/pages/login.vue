<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h3 class="text-info">Login</h3>
            <form @submit.prevent="login()">
              <!-- <div class="form-group">
                <input type="text" class="form-control" placeholder="Name" />
              </div> -->
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
              <button type="submit" class="btn btn-primary mt-3 btn-block">Login</button>
              <div class="text-xs "> Not Registered? <nuxt-link class="text-blue-600" to="/register">Register</nuxt-link></div>
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
    };
  },
  mounted() {
    this.$axios.$get("/sanctum/csrf-cookie");
  },
  methods: {
    async login() {
      this.$nuxt.$loading.start();
      try {
        await this.$auth.loginWith("laravelSanctum", { data: this.form });
        this.$router.push({
          path: "/",
        });
      } catch (err) {
        console.log(err);
      }
      this.$nuxt.$loading.finish();
    },
  },
};
</script>
