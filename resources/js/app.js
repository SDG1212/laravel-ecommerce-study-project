import './bootstrap'

import { createApp } from 'vue'
import AlertBoxComponent from '@/components/AlertBoxComponent.vue'
import CatalogComponent from '@/components/CatalogComponent.vue'
import Header from '@/components/Header.vue'

const header = createApp(Header).mount('#header')

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
