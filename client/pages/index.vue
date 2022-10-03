<template>
  <div class="container text-center">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Blog</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <nuxt-link to="/login" class="nav-link">Login</nuxt-link>
          </li>
          <li class="nav-item">
            <nuxt-link to="/register" class="nav-link">Register</nuxt-link>
          </li>
          <li class="nav-item">
            <nuxt-link to="/category" class="nav-link">Category</nuxt-link>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>
<script>
export default {

}
</script>