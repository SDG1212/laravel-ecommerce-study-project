import { reactive } from 'vue'

export const store = reactive({
  products: [],
  total: 0.0,
  addProductToCart(id) {
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
  removeProduct(id) {
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
  }
})
