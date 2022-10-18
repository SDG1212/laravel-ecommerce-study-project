<template>
    <div class="product-card">
        <img :src="image" :alt="name" />
        <div>{{ name }}</div>
    </div>
</template>

<script>
  export default {
    props: ['id', 'name', 'image'],
    data() {
      return {
        store,
      }
    },
  }
</script>

<style>
  .product-card {
  	width: 100%;
  }
</style>