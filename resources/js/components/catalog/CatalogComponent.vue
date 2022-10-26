<template>
  <div class="catalog" :class="{ '--visible': isVisible }">
    <div class="catalog__wrapper">
      <ProductCard v-for="product in products" :id="product.id" :name="product.name" :image="product.image"></ProductCard>
    </div>
    <div class="catalog__nav">
      <Pagination @paginate="paginate" :meta="meta"></Pagination>
      <CatalogToggle @click="paginateMore" :is-active="isActive" :links="links"></CatalogToggle>
    </div>
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
        isVisible: false,
      }
    },
    mounted() {
      const instance = axios.create();

      instance.interceptors.request.use((config) => {
          this.isVisible = false;

          return config;
        }, (error) => {
          return Promise.reject(error);
        });

      instance.interceptors.response.use((response) => {
          this.isVisible = true;

          return response;
        }, (error) => {
          return Promise.reject(error);
        });

      instance.get('api/products').then((response) => {
          this.products = response.data.data
          this.links = response.data.links
          this.meta.links = response.data.meta.links
        }).catch(function(error) {
          console.log(error)
        });
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

<style lang="scss">
  .catalog {
    position: relative;

    &:not(.--visible) {
      pointer-events: none;
    }
    &:not(.--visible):before {
      content: "";
      position: absolute;
      top: 50%;
      left: 50%;
      margin: -24px;
      display: block;
      width: 48px;
      height: 48px;
      border: 4px solid #fff;
      border-radius: 50%;
      border-top-color: #940101;
      animation: spin 1s ease-in-out infinite;
      z-index: 1;
    }

    &:not(.--visible) > * {
      opacity: 0.4;
    }

    &__wrapper {
      width: 100%;
      max-width: 1280px;
      padding: 48px 16px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
      grid-gap: 24px;
    }

    &__nav {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 48px 32px;
    }
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }
</style>
