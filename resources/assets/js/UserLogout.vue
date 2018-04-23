<template lang="html">
  <div class="logout">
    <h2>Log Out is finish. Good Bye!</h2>
    <router-link to="/welcome" @click="refresh()">Click me!</router-link>
  </div>
</template>

<script>
export default {
  methods: {
    refresh() {
      console.log(this.$router)
      
    }
  },

  mounted() {
    localStorage.removeItem('token')
  }
}
</script>

<style lang="css">
</style>
