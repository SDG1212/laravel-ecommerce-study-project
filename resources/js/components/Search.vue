<template>
  <form class="search__form">
    <input class="search__input" type="text" value="123" placeholder="Введите текст..." />
    <button class="search__button" type="button"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.8 24"><path d="M20.74,21l-7.13-7.78A9,9,0,0,0,13.46.64,9,9,0,0,0,.74.64a9,9,0,0,0,0,12.72,9,9,0,0,0,12,.67l7.13,7.78a.6.6,0,0,0,.88-.81ZM-.7,7a7.8,7.8,0,1,1,7.8,7.8A7.81,7.81,0,0,1-.7,7Z" transform="translate(1.9 2)"></path></svg></button>
  </form>
</template>

<script>
  export default {
    data() {
      return {
        products: [],
      }
    },
  }
</script>

<style>
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
