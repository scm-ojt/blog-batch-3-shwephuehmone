<template>
  <div>
    <div class="flex items-center justify-center h-screen">
      <div class="max-w-xl p-5 shadow">
        <div v-if="!$auth.loggedIn">
          <h3>Welcome</h3>
        </div>
        <div v-if="$auth.loggedIn">
          <div>Name:{{ $auth.user.name }}</div>
          <div>Email:{{ $auth.user.email }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "IndexPage",
};
</script>
