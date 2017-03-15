<template>
  <div>
    <top></top>
    <router-view></router-view>
  </div>
</template>

<script>
  export default {
    name: 'app',
    components: {
      'top': function(resolve) {
        require(['./components/Header.vue'], resolve)
      }
    },
    mounted() {
      const self = this
      self.$store.dispatch('CHECKONLINE')
    }
  }
</script>

<style>
    #app {
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      text-align: center;
      color: #2c3e50;
    }
    body{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Roboto","Open Sans",Arial,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",STHeiti,"WenQuanYi Micro Hei",SimSun,sans-serif;
      position: relative;
      font-weight: 200;
    }
    ul{
      list-style-type: none;
    }
</style>
