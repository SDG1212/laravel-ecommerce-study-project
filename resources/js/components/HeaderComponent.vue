<template>
  <div class="header__nav">
    <div class="header__nav-wrapper">
      <Search></Search>
      <Cart></Cart>
    </div>
  </div>
</template>

<script>
  import Search from '@/components/SearchComponent.vue'
  import Cart from '@/components/CartComponent.vue'

  export default {
    components: {
      Search,
      Cart,
    },
  }
</script>

<style>
  .header__nav-wrapper {
    width: 100%;
    max-width: 1280px;
    padding: 0 16px;
    margin: 0 auto;
    display: flex;
  }
</style>
