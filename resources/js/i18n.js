import { createI18n } from 'vue-i18n';

const instance = createI18n({
  locale: 'ru',
  messages: {
  	ru: {
    	added_to_cart: 'Товар добавлен в корзину!',
    },
  }
});

export default instance;

export const i18n = instance.global;
