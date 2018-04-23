<template lang="html">
  <div class="info">
    <div class="user-info">
      <div class="elementInfo">Name: {{ name }}</div>
      <div class="elementInfo">Email: {{ email }}</div>
    </div>
    <div class="buttns">
      <a @click="updateUser()" class="source current-font">Change Profile</a>
        <UserUpdate
          v-if="this.isUpdate"
          v-on:close="closeUpdate"
          v-bind:nameUser="this.name"
          v-bind:emailUser="this.email"
        ></UserUpdate>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import UserUpdate from './UserUpdate.vue';

export default {
  data: () => ({
    name: '',
    email: '',
    isUpdate: false
  }),

  components: {
    UserUpdate
  },

  methods: {
    getUser() {
      //axios.defaults.headers.common['Authorization'] = localStorage.getItem('token')
      axios.get('user', {
        headers: {
          Authorization: localStorage.getItem('token')
        }
      })
      .then(response => {
        console.log(response)
        this.name = response.data[0].name
        this.email = response.data[0].email
      })
      .catch(e => {
        console.log("ERROR! " + e);
      })
    },

    updateUser() {
      this.isUpdate = true
    },

    closeUpdate(value) {
      this.isUpdate = false
      this.name = value
    }
  },

  mounted() {
    this.getUser()
    //  console.log(localStorage.getItem('token'))
  }
}
</script>

<style lang="css" scoped>

  .info {
    width: 100%;
    height: 70%;
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
    align-items: center;
  }

  .user-info {
    display: flex;
    flex-direction:row;
    width: 25%;
    justify-content: space-between;
    color: rgb(79, 31, 60);
    font-family: Arial;
  }

  .buttns {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
    height: 70%;
  }

  .cont {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-evenly;
  }
</style>
