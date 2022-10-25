import './bootstrap'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import Search from '@/components/header/SearchComponent.vue'
import Cart from '@/components/header/CartComponent.vue'
import Catalog from '@/components/catalog/CatalogComponent.vue'

const pinia = createPinia().use(() => { window.alertBox })

const app = createApp({})
  .directive('click-outside', {
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
  })
  .use(pinia)
  .component('Cart', Cart)
  .component('Search', Search)
  .component('Catalog', Catalog)
  .mount('#app')
