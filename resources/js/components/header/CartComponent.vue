<template>
  <div class="cart" v-click-outside="() => { this.isActive = false }">
    <button class="cart__toggle" type="button" @click="toggle()">
      <svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M509.867,89.6c-2.133-2.133-4.267-4.267-8.533-4.267H96L85.333,29.867c0-4.267-6.4-8.533-10.667-8.533h-64
          C4.267,21.333,0,25.6,0,32c0,6.4,4.267,10.667,10.667,10.667h55.467l51.2,260.267c6.4,34.133,38.4,59.733,72.533,59.733H435.2
          c6.4,0,10.667-4.267,10.667-10.667c0-6.4-4.267-10.667-10.667-10.667H192c-17.067,0-34.133-8.533-42.667-23.467L460.8,275.2
          c4.267,0,8.533-4.267,8.533-8.533L512,96C512,96,512,91.733,509.867,89.6z M450.133,256l-311.467,40.533l-38.4-192H486.4
          L450.133,256z"></path><path d="M181.333,384C151.467,384,128,407.467,128,437.333c0,29.867,23.467,53.333,53.333,53.333
          c29.867,0,53.333-23.467,53.333-53.333C234.667,407.467,211.2,384,181.333,384z M181.333,469.333c-17.067,0-32-14.934-32-32
          s14.933-32,32-32c17.067,0,32,14.934,32,32S198.4,469.333,181.333,469.333z"></path><path d="M394.667,384c-29.867,0-53.333,23.467-53.333,53.333c0,29.867,23.467,53.333,53.333,53.333
          c29.867,0,53.333-23.467,53.333-53.333C448,407.467,424.533,384,394.667,384z M394.667,469.333c-17.067,0-32-14.934-32-32
          s14.933-32,32-32c17.067,0,32,14.934,32,32S411.733,469.333,394.667,469.333z"></path></svg>
        <span class="cart__counter">{{ this.products.length }}</span>
    </button>
    <div class="cart__dropdown" :class="{ '--active': isActive, '--visible': isVisible }">
      <div v-if="!products.length" class="cart__title">{{ $t('empty_cart') }}</div>
      <ul v-else class="cart__product-menu">
        <li v-for="product in products" class="cart__product-item">
          <img class="cart__product-image" :src="product.image" :alt="product.name" />
          <div class="cart__product-info">
            <div class="cart__product-name">{{ product.name }}</div>
            <div class="cart__product-price">{{ product.price }} ??????</div>
            <div class="cart__product-nav">
              <div class="cart__product-quantity-wrapper">
                <button @click="decrementProductQuantity(product.id, (product.quantity))" type="button">-</button>
                <input @blur="editProduct(product.id, $event)" type="text" :value="product.quantity" size="3" />
                <button @click="incrementProductQuantity(product.id, (product.quantity))" type="button">+</button>
              </div>
              <button class="cart__remove" @click="deleteProduct(product.id)" type="button">{{ $t('delete') }}</button>
            </div>
          </div>
        </li>
        <li class="cart__total"><b>{{ $t('total') }}</b>{{ total }} ??????</li>
      </ul>
    </div>
  </div>
</template>

<script>
  import { mapWritableState } from 'pinia'
  import { mapActions } from 'pinia'
  import { useCartStore } from '@/store'

  export default {
    data() {
      return {
        isActive: false,
        isVisible: false,
      }
    },
    computed: {
      ...mapWritableState(useCartStore, {
        products: 'products',
        total: 'total',
      }),
    },
    methods: {
      ...mapActions(useCartStore, {
        editProductInCart: 'editProduct',
        deleteProductFromCart: 'deleteProduct',
      }),
      toggle() {
        this.isActive = this.isActive ? false : true

        if (this.isActive) {
          const instance = axios.create();

          instance.interceptors.request.use((config) => {
            this.isVisible = false;

            return config;
          }, function (error) {
            return Promise.reject(error);
          });

          instance.interceptors.response.use((response) => {
            this.isVisible = true;

            return response;
          }, function (error) {
            return Promise.reject(error);
          });

          instance.get('cart/info')
            .then((response) => {
              if (response.data.message) {
                this.products = []
                this.total = 0.0
              } else {
                this.products = response.data.data.products
                this.total = response.data.data.total
              }
            })
            .catch(function(error) {
              console.log(error)
            })
        }
      },
      deleteProduct(id) {
        this.deleteProductFromCart(id)
      },
      editProduct(id, event) {
        this.editProductInCart(id, event.target.value)
      },
      decrementProductQuantity(id, quantity) {
        if (quantity <= 1) {
          return;
        }

        quantity -= 1
        this.editProductInCart(id, quantity)
      },
      incrementProductQuantity(id, quantity) {
        quantity += 1
        this.editProductInCart(id, quantity)
      },
    }
  }
</script>

<style lang="scss">
  .cart {
    position: relative;
    width: 64px;
    height: 64px;

    &__toggle {
      position: relative;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    &__counter {
      position: absolute;
      top: 4px;
      right: 4px;
      min-width: 24px;
      min-height: 24px;
      background: #c70101;
      border-radius: 50%;
      font-size: 15px;
      font-weight: 500;
      line-height: 24px;
      color: #fff;
    }

    &__dropdown {
      display: none;
      justify-content: center;
      align-items: center;
      position: absolute;
      top: calc(100% + 16px);
      right: 0;
      min-width: 480px;
      min-height: 120px;
      max-height: calc(100vh - 64px - 16px - 16px);
      padding: 24px 16px;
      background: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, .2);
      overflow: auto;

      &.--active {
        display: flex;
      }
    }

    &__dropdown:not(.--visible) > * {
      display: none;
    }

    &__dropdown:not(.--visible):before {
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

    &__dropdown-menu {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    &__product-item {
      display: flex;
      padding: 8px 0;
    }

    &__product-image {
      flex: 1 0 auto;
      max-width: 50%;
      padding: 0 16px;
    }

    &__product-info {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      flex: 1 0 auto;
      max-width: 50%;
      padding: 0 16px;
    }

    &__product-name {
      text-align: left;
      font-weight: 600;
      line-height: 1.2;
    }

    &__product-price {
      font-size: 18px;
      font-weight: 400;
      line-height: 1;
    }

    &__product-quantity-wrapper {
      padding: 8px 0;
      display: flex;

      input {
        max-width: 100%;
      }

      button {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        flex: 1 0 48px;
        max-width: 48px;
        padding: 0 16px;
      }
    }

    &__title {
      text-align: center;
      text-transform: uppercase;
      font-size: 24px;
      font-weight: 300;
      line-height: 1.2;
    }

    &__total {
      padding: 8px 0;
      text-align: right;
      font-size: 18px;
      font-weight: 300;
      line-height: 1.2;

      b {
        padding-right: 8px;
        font-weight: 700;
      }
    }

    &__total b {
    }
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }
</style>

<i18n>
{
  ru: {
    empty_cart: '?????????????? ??????????',
    total: '??????????',
    delete: '??????????????',
  }
}
</i18n>
