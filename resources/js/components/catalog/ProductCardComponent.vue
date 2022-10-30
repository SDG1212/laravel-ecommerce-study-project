<template>
    <div class="product-card">
      <a class="product-card__image-link" href="#">
        <img class="product-card__image" :src="image" :alt="name" />
      </a>
      <div class="product-card__content">
        <a class="product-card__name" href="#">{{ name }}</a>
        <div class="product-card__price">{{ price }}</div>
      </div>
      <button class="product-card__add-to-cart" @click="addProduct(id)">{{ $t('add_to_cart') }}</button>
    </div>
</template>

<script>
  import { mapActions } from 'pinia'
  import { useCartStore } from '@/store'

  export default {
    props: ['id', 'name', 'image', 'price'],
    methods: {
      ...mapActions(useCartStore, ['addProduct']),
    }
  }
</script>

<style lang="scss">
  .product-card {
    display: flex;
    flex-direction: column;
  	width: 100%;

    &__image {
      max-width: 100%;
      height: auto;
      transition: 0.2s;
    }

    &__image-link:hover &__image {
      opacity: 0.6;
    }

    &__content {
      flex: 1 0 auto;
      margin: 4px 0 8px;
    }

    &__name {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      min-height: calc(14px * 2 * 1.3);
      overflow: hidden;
      text-overflow: ellipsis;
      font-size: 14px;
      font-weight: 400;
      line-height: 1.3;
      color: #333;
      transition: 0.2s;

      &:hover {
        color: #940101;
      }
    }

    &__price {
      margin: 4px 0 0;
      font-size: 16px;
      font-weight: 700;
      line-height: 1.2;
      color: #333;
    }

    &__add-to-cart {
      display: inline-flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      padding: 8px 16px;
      background: #c70101;
      border-radius: 4px;
      text-transform: uppercase;
      font-size: 15px;
      font-weight: 500;
      line-height: 1;
      color: #fff;
      transition: 0.2s;

      &:hover {
        background: #940101;
      }
    }
  }
</style>

<i18n>
{
  ru: {
    add_to_cart: 'Добавить в корзину',
  },
}
</i18n>
