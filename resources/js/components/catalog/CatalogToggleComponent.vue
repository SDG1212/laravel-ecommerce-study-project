<template>
  <button v-if="links.next" class="catalog__toggle" :class="{ '--active': isActive }" type="button">Просмотреть еще</button>
</template>

<script>
  export default {
    props: [ 'is-active', 'links' ],
  }
</script>

<style>
  .catalog__toggle {
    position: relative;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    max-width: 256px;
    padding: 12px 24px;
    background: #c70101;
    border-radius: 4px;
    text-transform: uppercase;
    font-size: 16px;
    font-weight: 500;
    line-height: 1;
    color: #fff;
    transition: 0.2s;
  }

  .catalog__toggle.--active {
    background: #940101;
    color: transparent;
    pointer-events: none;
  }

  .catalog__toggle.--active:before {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    margin: -12px;
    display: block;
    width: 24px;
    height: 24px;
    border: 2px solid #fff;
    border-radius: 50%;
    border-top-color: #940101;
    animation: spin 1s ease-in-out infinite;
    z-index: 1;
  }

  .catalog__toggle:hover {
    background: #940101;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }
</style>
