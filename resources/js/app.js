import './bootstrap'

import { createApp } from 'vue'
import AlertBoxComponent from '@/components/AlertBoxComponent.vue'
import CatalogComponent from '@/components/catalog/CatalogComponent.vue'
import Header from '@/components/header/HeaderComponent.vue'

const header = createApp(Header).directive('click-outside', {
  mounted(element, binding, vnode) {
    element.clickOutsideEvent = function(event) {
      if (!(element === event.target || element.contains(event.target))) {
        binding.value(event, element);
      }
    };
    document.body.addEventListener('click', element.clickOutsideEvent);
  },
  unmounted(element) {
    document.body.removeEventListener('click', element.clickOutsideEvent);
  }
}).mount('#header')

const alertBox = createApp(AlertBoxComponent).mount('#alert-box')

const catalog = createApp(CatalogComponent).mount('#catalog')

document.getElementById('newsletter__form').onsubmit = function(event) {
  event.preventDefault()

  let thisForm = this

  axios({
      method: 'post',
      url: this.action,
      data: new FormData(this),
    }).then(function(response) {
      alertBox.show(true, 'Вы подписаны на новостную рассылку!')

      thisForm.classList.add('--disabled')

      thisForm.querySelector('.newsletter__input').setAttribute('disabled', true)
    }).catch(function (error) {
      let message = Object.values(error.response.data)[0]

      alertBox.show(false, message)
    })
}
