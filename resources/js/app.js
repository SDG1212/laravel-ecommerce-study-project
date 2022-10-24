import './bootstrap'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import CatalogComponent from '@/components/catalog/CatalogComponent.vue'
import Header from '@/components/header/HeaderComponent.vue'

const pinia = createPinia()

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
}).use(pinia).mount('#header')

const catalog = createApp(CatalogComponent).use(pinia).mount('#catalog')

window.alertBox = {
  show: (type, message) => {
    window.alertBox.hide()

    let html = document.createElement('div')
    html.classList.add('alert-box')
    html.classList.add(`--${type}`)

    html.innerHTML = message

    document.body.appendChild(html)

    document.addEventListener('click', window.alertBox.clickHandler)
  },
  hide: ($element) => {
    document.querySelectorAll('.alert-box').forEach(element => element.remove())

    document.removeEventListener('click', window.alertBox.clickHandler)
  },
  clickHandler: () => {
    if (document.querySelector('.alert-box').contains(event.target)) {
      return
    }

    window.alertBox.hide()
  },
}

document.getElementById('newsletter__form').onsubmit = function(event) {
  event.preventDefault()

  let thisForm = this

  axios({
      method: 'post',
      url: this.action,
      data: new FormData(this),
    }).then(function(response) {
      window.alertBox.show('success', 'Вы подписаны на новостную рассылку!')

      thisForm.classList.add('--disabled')

      thisForm.querySelector('.newsletter__input').setAttribute('disabled', true)
    }).catch(function (error) {
      let message = Object.values(error.response.data)[0]

      window.alertBox.show('error', message)
    })
}
