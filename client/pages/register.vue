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
                />
              </div>
              <div class="text-danger mb-3" v-if="errors.name">*{{ errors.name[0] }}</div>
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
              </div>
              <div class="text-danger mb-3" v-if="errors.password">
                *{{ errors.password[0] }}
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
      this.$axios
        .post("http://127.0.0.1:8000/register", this.form)
        .then((response) => {
          this.$router.push({
            path: "/login",
          });
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },
  },
};
</script>
