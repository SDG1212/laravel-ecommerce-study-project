<template>
  <div class="main__wrapper">
    <ProductCard v-for="product in products" :id="product.id" :name="product.name" :image="product.image"></ProductCard>
  </div>
  <div class="main__nav">
    <ul class="pagination">
      <li v-for="link in meta.links">
        <span v-if="link.active">{{ link.label }}</span>
        <button v-else type="button" @click="paginate(link.url)">{{ link.label }}</button>
      </li>
    </ul>
    <button v-if="links.next" @click="paginateMore" class="catalog__toggler" :class="{ '--active': isActive }" type="button">Просмотреть еще</button>
  </div>
</template>

<script>
  import ProductCard from '@/components/catalog/ProductCardComponent.vue'

  export default {
    components: { ProductCard },
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

  ul.pagination {
    list-style: none;
    padding: 24px 0;
    margin: 0;

    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  ul.pagination li {
    padding: 0 2px;
  }

  ul.pagination li:first-child {
    padding-left: 0;
  }

  ul.pagination li:last-child {
    padding-right: 0;
  }

  ul.pagination li.--hidden {
    display: none;
  }

  ul.pagination li button, ul.pagination li span {
    display: inline-flex;
    justify-content: center;
    align-items: center;

    padding: 8px 12px;

    border: 1px solid;
    border-radius: 4px;

    font-size: 16px;
    font-weight: 400;
    line-height: 1;
  }

  ul.pagination li button {
    background: #fff;
    border-color: #ddd;

    color: #333;

    transition: .2s;
  }

  ul.pagination li button:hover, ul.pagination li button:focus {
    background: #eee;
    border-color: #ddd;

    color: #333;
  }

  ul.pagination li span {
    background: #c70101;
    border-color: #c70101;

    color: #fff;
  }

  .catalog__toggler {
    position: relative;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    max-width: 256px;
    padding: 12px 24px;
    background: #c70101;
    border-radius: 4px;
    text-transform: uppercase;
    font-size: 16px;
    font-weight: 500;
    line-height: 1;
    color: #fff;
    transition: 0.2s;
  }

  .catalog__toggler.--active {
    background: #940101;
    color: transparent;
    pointer-events: none;
  }

  .catalog__toggler.--active:before {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    margin: -12px;
    display: block;
    width: 24px;
    height: 24px;
    border: 2px solid #fff;
    border-radius: 50%;
    border-top-color: #940101;
    animation: spin 1s ease-in-out infinite;
    z-index: 1;
  }

  .catalog__toggler:hover {
    background: #940101;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }
</style>
