<template>
  <div class="main__wrapper">
    <ProductCard v-for="product in products" :id="product.id" :name="product.name" :image="product.image"></ProductCard>
  </div>
  <div class="main__nav">
    <Pagination @paginate="paginate" :meta="meta"></Pagination>
    <CatalogToggle @click="paginateMore" :is-active="isActive" :links="links"></CatalogToggle>
  </div>
</template>

<script>
  import ProductCard from '@/components/catalog/ProductCardComponent.vue'
  import Pagination from '@/components/catalog/PaginationComponent.vue'
  import CatalogToggle from '@/components/catalog/CatalogToggleComponent.vue'

  export default {
    components: { ProductCard, Pagination, CatalogToggle },
    data() {
      return {
        products: [],
        links: {
          first: null,
          last: null,
          next: null,
          prev: null,
        },
        meta: {
          links: []
        },
        isActive: false,
      }
    },
    mounted() {
      axios.get('api/products')
        .then((response) => {
          this.products = response.data.data
          this.links = response.data.links
          this.meta.links = response.data.meta.links
        })
        .catch(function(error) {
          console.log(error)
        })
    },
    methods: {
      paginateMore: function() {
        const instance = axios.create();

        instance.interceptors.request.use((config) => {
            this.isActive = true

            return config;
          }, function (error) {
            return Promise.reject(error);
          });

        instance.interceptors.response.use((response) => {
            this.isActive = false

            return response;
          }, function (error) {
            return Promise.reject(error);
          });

        instance.get(this.links.next)
          .then((response) => {
            this.products.push(...response.data.data)
            this.links = response.data.links
            this.meta.links = response.data.meta.links
          })
          .catch(function(error) {
            console.log(error)
          })
      },
      paginate: function(link) {
        axios.get(link)
          .then((response) => {
            this.products = response.data.data
            this.links = response.data.links
            this.meta.links = response.data.meta.links
          })
          .catch(function(error) {
            console.log(error)
          })
      }
    }
  }
</script>

<style>
  .product-card {
    width: 100%;
  }
</style>
