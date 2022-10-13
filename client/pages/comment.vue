<template>
  <div>
    <div>
      <b-form-textarea
        id="textarea"
        v-model="text"
        placeholder="Comment here..."
        rows="3"
        max-rows="6"
        class="mt-4"
      ></b-form-textarea>
      <pre class="mt-3 mb-0">{{ text }}</pre>
    </div>
  </div>
</template>
<script>
export default {};
</script>
