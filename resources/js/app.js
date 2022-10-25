import './bootstrap'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { clickOutside } from '@/directives/ClickOutsideDirective'
import Search from '@/components/header/SearchComponent.vue'
import Cart from '@/components/header/CartComponent.vue'
import Catalog from '@/components/catalog/CatalogComponent.vue'

const pinia = createPinia().use(() => { window.alertBox })

const app = createApp({})
  .directive('click-outside', clickOutside)
  .use(pinia)
  .component('Cart', Cart)
  .component('Search', Search)
  .component('Catalog', Catalog)
  .mount('#app')
