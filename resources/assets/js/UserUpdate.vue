<template lang="html">
  <div class="cont">
    <div class="iputs">
      <label>Имя<input type="text" v-model="name"></label>
      <label>E-mail<input type="text" v-model="login"></label>
      <label>Пароль<input type="text" v-model="password"></label>
      <label>Подтверждение пароля<input type="text" v-model="rePassword"></label>
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

  props: [
    'nameUser', 'emailUser'
  ],

  methods: {
    postRegister() {
      if(this.isValid) {
        this.error = false
        axios.post('/userUpdate', {
          name: this.name,
          email: this.login,
          password: this.password
        }, {
          headers: {
            Authorization: localStorage.getItem('token')
          }
        })
        .then(responce => {
          this.$router.push({ path: '/user' })
          //console.log(responce.data)
        })
        .catch(e => {
          console.log(e)
        })
        this.$emit('close', this.name)
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
    }
  },

  mounted() {
    console.log(this)
    this.name = this.nameUser
    this.login = this.emailUser
  }
}
</script>

<style lang="css">
  .cont {
    display: flex;
    flex-direction: column;
    height: 100%;
    border: 1px solid rgb(19, 83, 119);
  }

  .iputs {
    display: flex;
    flex-direction: column;
    height: 90%;
    align-items: center;
    justify-content: space-evenly;
  }

  label {
    display: flex;
    width: 100%;
    justify-content: space-between;
  }

  input {
    margin: 0 5px;
    color: rgb(19, 83, 119);
  }

  button {
    border: 1.5px solid #FF70A5;
    /* background-color: rgb(19, 83, 119); */
  }
</style>
