<template>
  <div class="iputs">
    <input name="login" type="text" v-model="login" placeholder="Enter login"/>
    <input name="password" type="text" v-model="password" placeholder="Enter password"/>
    <input type="submit" @click="loginForm()" value="submit">
    <div v-model="token">{{token}}</div>
  </div>
</template>

<script>
  import axios from 'axios';
  export default {
    data: () => ({
        login: '',
        password: '',
        token: 'haha'
    }),

    methods: {
      loginForm () {
        axios.get('login', {
          params: {
            email: this.login,
            password: this.password
          }
        })
        .then(response => {
          this.token = response.data.token ? response.data.token : response.data.error
          localStorage.setItem('token', this.token);
          this.$router.push('/user', () => {
            this.$router.go(this.$router.currentRoute)
          })
        })
        .catch(e => {
          console.log("ERROR! " + e);
        })
      }
    }

  };

</script>
