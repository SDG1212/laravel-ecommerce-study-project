<template>
    <div class="product-card">
        <img :src="image" :alt="name" />
        <button class="" @click="addProductToCart()">{{ name }}</button>
    </div>
</template>

<script>
  import { store } from '@/store.js'

  export default {
    props: ['id', 'name', 'image'],
    data() {
      return {
        store,
      }
    },
    methods: {
      addProductToCart: function() {
        store.addProductToCart(this.id)
      },
    }
  }
</script>

<style>
  .product-card {
  	width: 100%;
  }
</style>