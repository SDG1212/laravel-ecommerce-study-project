import { defineStore } from 'pinia'

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
        this.products = response.data.data.products
        this.total = response.data.data.total
      })
      .catch(function (error) {
        console.log(error);
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
        console.log(error);
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
        console.log(error);
      });
    },
  },
})
