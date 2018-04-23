<template lang="html">
  <div class="container">
    <div class="welcome" @click="HeyGirl()">{{ message }}</div>
    <div class="elements">
      <div v-if="this.isLoginNow" class="element">
        <router-link to="/calendar">Calendar</router-link>
      </div>
      <div v-if="this.isLoginNow" class="element">
        <router-link to="/user">User</router-link>
      </div>
      <div v-if="!this.isLoginNow" class="is-not-user">
        <div class="element register">
          <router-link to="/register">Registration</router-link>
        </div>
        <div class="element login">
          <a @click="login()" class="login">Login</a>
        </div>
      </div>
      <div v-if="this.isLoginNow" class="is-user">
        <div class="element">
          <a @click="logout()" class="logout">Logout</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {

  data: () => ({
    message: 'Hello world!',
    isLogin: false
  }),

  methods: {
    HeyGirl() {
      this.message = this.message == 'Hey Girl' ? 'Hello World!' : 'Hey Girl'
    },

    logout() {
      localStorage.removeItem('token')
      this.isLogin = false
      this.$router.push({ path: '/login' })
    },

    login() {
      this.$router.push({ path: '/login' })
    }
  },

  computed: {
    isLoginNow() {
      this.isLogin = !!localStorage.getItem('token')
      return this.isLogin
    }
  }
}
</script>

<style lang="css" scoped>
  .is-not-user {
    display: flex;
    flex-direction: row;
    justify-content: space-evenly;
    width: 100%;
  }

  .elements {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-evenly;
    width: 45%;
  }

  .welcome {
    margin-left: auto;
  }

  .container {
    width: 100%;
    height: 10%;
    background-color: rgb(19, 83, 119);
    font-family: "Mistral";
    font-size: 30pt;
    /* color: rgb(0, 255, 118); */
    color: #FF70A5;
    display: flex;
    justify-content:center;
    align-items: center;
  }
  a {
    color: #FF70A5;
    text-decoration: none;
  }
  a:hover {
    color: #e62c71;
  }
</style>
