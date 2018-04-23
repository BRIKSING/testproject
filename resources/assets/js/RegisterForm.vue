<template lang="html">
  <div class="reg cont">
    <div class="iputs register">
      <label class="register-label">Имя<input type="text" v-model="name"></label>
      <label class="register-label">E-mail<input type="text" v-model="login"></label>
      <label class="register-label">Пароль<input type="text" v-model="password"></label>
      <label class="register-label">Подтверждение пароля<input type="text" v-model="rePassword"></label>
      <input type="submit" @click="postRegister()">
    </div>
    <div v-if="this.error" class="error">
      SOMETHING IS WRONG
    </div>
  </div>
</template>

<script>
import axios from 'axios';


export default {
  data: () => ({
    name: '',
    login: '',
    password: '',
    rePassword: '',
    error: false
  }),

  methods: {
    postRegister() {
      if(this.isValid) {
        this.error = false
        axios.post('/register', {
          name: this.name,
          email: this.login,
          password: this.password
        })
        .then(responce => {
          this.$router.push({ path: '/login' })
        })
        .catch(e => {
          console.log(e)
        })
      } else {
        this.error = true
      }
    }
  },

  computed: {
    isValid: function () {
      return  this.password == this.rePassword &&
              this.password != "" &&
              /(.+)@.+\.\w{1,4}/.test(this.login)
    },

    goToLog: function () {
      return this.$router.push({ path: '/login' })
    }
  }
}
</script>

<style lang="css">

  .regster {
    width: 50%;
    height: 70%;

  }

  .reg {
    align-items: center;
    border: 0px;
  }
</style>
