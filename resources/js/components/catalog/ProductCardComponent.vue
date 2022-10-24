<template>
    <div class="product-card">
        <img :src="image" :alt="name" />
        <button class="" @click="addProduct(id)">{{ name }}</button>
    </div>
</template>

<script>
  import { mapActions } from 'pinia'
  import { useCartStore } from '@/store'

  export default {
    props: ['id', 'name', 'image'],
    methods: {
      ...mapActions(useCartStore, ['addProduct']),
    }
  }
</script>

<style>
  .product-card {
  	width: 100%;
  }
</style>