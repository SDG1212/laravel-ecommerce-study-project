import './bootstrap'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { createI18n } from 'vue-i18n'
import { clickOutside } from '@/directives/ClickOutsideDirective'
import Search from '@/components/header/SearchComponent.vue'
import Cart from '@/components/header/CartComponent.vue'
import Catalog from '@/components/catalog/CatalogComponent.vue'

const pinia = createPinia().use(() => { window.alertBox })

const i18n = createI18n({})

const app = createApp({})
  .directive('click-outside', clickOutside)
  .use(pinia)
  .use(i18n)
  .component('Cart', Cart)
  .component('Search', Search)
  .component('Catalog', Catalog)
  .mount('#app')
