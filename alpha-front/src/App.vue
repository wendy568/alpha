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
  font-family: Verdana;
}
ul{
  list-style-type: none;
}
</style>
