<template>
  <div class="search">
    <form class="search__form">
      <input @blur="this.isVisible = false" @focus="this.isVisible = true" @input="event => text = event.target.value" class="search__input" type="text" :value="text" :placeholder="$t('placeholder')" />
      <button class="search__button" type="button"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.8 24"><path d="M20.74,21l-7.13-7.78A9,9,0,0,0,13.46.64,9,9,0,0,0,.74.64a9,9,0,0,0,0,12.72,9,9,0,0,0,12,.67l7.13,7.78a.6.6,0,0,0,.88-.81ZM-.7,7a7.8,7.8,0,1,1,7.8,7.8A7.81,7.81,0,0,1-.7,7Z" transform="translate(1.9 2)"></path></svg></button>
    </form>
    <ul v-if="products.length" class="search__dropdown-menu" :class="{ '--active': isVisible }">
      <li class="search__menu-item" v-for="product in products">
        <div class="product-card">
          <img :src="product.image" :alt="product.name" />
          <span>{{ product.name }}</span>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        products: [],
        text: '',
        isVisible: false,
      }
    },
    mounted() {
      this.$watch('isVisible', () => {
        if (this.isVisible) {
          document.getElementById('header').classList.add('--active');
        } else {
          document.getElementById('header').classList.remove('--active');
        }
      });

      this.$watch('text', (text) => {
        axios.post('search', {
          text: this.text,
        })
        .then((response) => {
          this.products = response.data.data
        })
        .catch(function(error) {
          console.log(error)
        })
      })
    },
  }
</script>

<style>
  .search {
    position: relative;
    flex: 1 0 auto;
    height: 64px;
    border: 1px solid #ddd;
    border-width: 0 1px;
  }

  .search__form {
    position: relative;
    width: 100%;
    height: 100%;
  }

  .search__input {
    width: 100%;
    height: 100%;
    padding: 0 48px 0 24px;
    background: #fff;
    border: 0;
    outline: 0;
    font-size: 15px;
    font-weight: 400;
    line-height: 1.2;
    color: #333;
    transition: 0.2s;
  }

  .search__input:focus {
    outline: 0;
    box-shadow: none;
    border-color: #c70101;
  }

  .search__input::placeholder {
    color: #666;
  }

  .search__button {
    position: absolute;
    top: 0;
    right: 0;

    width: 48px;
    height: 100%;
    padding: 0;

    background: transparent;

    display: inline-flex;
    justify-content: center;
    align-items: center;
  }

  .search__button svg {
    fill: #666;
    transition: .2s;
  }

  .search__button:hover svg {
    fill: #c70101;
  }

  .search__dropdown-menu {
    position: absolute;
    top: 100%;
    left: -1px;
    width: calc(100% + 3px);
    padding: 16px 42px 16px 24px;
    border: 1px solid #ddd;
    border-width: 0 1px 1px;
    background: #fff;
    display: none;
    flex-wrap: wrap;
  }

  .search__dropdown-menu.--active {
    display: flex;
  }

  .search__menu-item {
    flex: 1 0 25%;
    max-width: 25%;
    padding: 0 16px;
  }

  @media screen and (max-width: 1024px) {
    .search__form {
      height: 48px;
      display: flex;
      align-items: center;
    }
  }

  @media screen and (max-width: 1024px) {
    .search__input {
      padding: 0 48px 0 0;
    }
  }
</style>

<i18n>
{
  ru: {
    placeholder: 'Введите название товара...',
  }
}
</i18n>
