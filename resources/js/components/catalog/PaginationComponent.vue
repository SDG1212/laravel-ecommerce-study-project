<template>
  <ul class="pagination">
    <li v-for="link in meta.links">
      <span v-if="link.active">{{ link.label }}</span>
      <button v-else type="button" @click="paginate(link.url)">{{ link.label }}</button>
    </li>
  </ul>
</template>

<script>
  export default {
    props: [ 'meta' ],
    methods: {
      paginate(url) {
        this.$emit('paginate', url);
      }
    },
  }
</script>

<style>
  ul.pagination {
    list-style: none;
    padding: 24px 0;
    margin: 0;

    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  ul.pagination li {
    padding: 0 2px;
  }

  ul.pagination li:first-child {
    padding-left: 0;
  }

  ul.pagination li:last-child {
    padding-right: 0;
  }

  ul.pagination li.--hidden {
    display: none;
  }

  ul.pagination li button, ul.pagination li span {
    display: inline-flex;
    justify-content: center;
    align-items: center;

    padding: 8px 12px;

    border: 1px solid;
    border-radius: 4px;

    font-size: 16px;
    font-weight: 400;
    line-height: 1;
  }

  ul.pagination li button {
    background: #fff;
    border-color: #ddd;

    color: #333;

    transition: .2s;
  }

  ul.pagination li button:hover, ul.pagination li button:focus {
    background: #eee;
    border-color: #ddd;

    color: #333;
  }

  ul.pagination li span {
    background: #c70101;
    border-color: #c70101;

    color: #fff;
  }
</style>
