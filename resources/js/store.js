import { defineStore } from 'pinia'
import { i18n } from '@/i18n.js'

export const useCartStore = defineStore('cart', {
  state: () => ({
    products: [],
    total: 0.0,
  }),
  actions: {
    addProduct(id) {
      axios.post('cart/add', {
        id: id,
      })
      .then((response) => {
        window.alertBox.show('success', i18n.t('added_to_cart'))

        this.products = response.data.data.products
        this.total = response.data.data.total
      })
      .catch(function (error) {
        window.alertBox.show('error', error.response.data.message);
      });
    },
    editProduct(id, quantity) {
      axios.post('cart/edit', {
        id: id,
        quantity: quantity,
      })
      .then((response) => {
        this.products = response.data.data.products
        this.total = response.data.data.total
      })
      .catch(function (error) {
        window.alertBox.show('error', error.response.data.message);
      });
    },
    deleteProduct(id) {
      axios.post('cart/delete', {
        id: id,
      })
      .then((response) => {
        this.products = response.data.data.products
        this.total = response.data.data.total
      })
      .catch(function (error) {
        window.alertBox.show('error', error.response.data.message);
      });
    },
  },
})
