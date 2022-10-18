<template>
  <div class="alert-box" :class="[{'--active': status}, isSuccess ? '--success' : '--error']">{{ message }}</div>
</template>

<script>
  export default {
    data() {
      return {
        isSuccess: false,
        message: '',
        status: false,
      }
    },
    methods: {
      show: function(isSuccess, message) {
        this.isSuccess = isSuccess
        this.message = message
        this.status = true

        document.addEventListener('click', this.clickHandler)
      },
      hide: function() {
        this.status = false

        document.removeEventListener('click', this.clickHandler)
      },
      clickHandler: function(event) {
        if (document.querySelector('.alert-box').contains(event.target))
          return

        this.hide()
      }
    }
  }
</script>

<style>
  .alert-box {
    display: none;
    position: fixed;
    top: 50px;
    left: 50%;
    transform: translate(-50%, 0);
    width: 100%;
    max-width: 480px;
    padding: 12px 24px;
    margin: 0 auto;
    background: #c70101;
    border-radius: 5px;
    box-shadow: 0 4px 50px 0 rgb(0 0 0 / 10%);
    text-align: center;
    font-size: 14px;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    z-index: 10001;
  }

  .alert-box.--active {
    display: block;
  }

  .alert-box.--error {
    background: #c70101;
  }

  .alert-box.--success {
    background: #5faf23;
  }
</style>
