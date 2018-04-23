<template lang="html">
  <div id="calendar">
    <div class="panel">
      <div class="time current-font">
        <div @click ="bacK()" class="bar"><</div>
        <div v-model="this.month" class="bar date">{{month}}</div>
        <div v-model="this.year" class="bar date">{{year}}</div>
        <div @click="nexT()" class="bar">></div>
      </div>
      <div class="create">
        <div @click="createDoing()" class="create-doing">Create Doing</div>
        <TaskCreate
          v-if="isShowTime"
          v-bind:isCreate="true"
          v-on:closeUpdCalendar="closeUpdate()"
        >Создать</TaskCreate>
      </div>
    </div>
    <div class="doings current-font ">
      <Doing
        v-for="(doing, index) in doings"
        v-bind:objDoing = "doing"
        v-bind:dayDoing = "index"
        v-bind:userID = "idUser"
        v-on:updateCalendar = "getCalendar()"
      ></Doing>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Doing from './Doing.vue';
import TaskCreate from './TaskUpdate.vue';

export default {
  data: () => ({
    doings: '',
    month: (new Date()).getMonth() + 1,
    year: (new Date()).getFullYear(),
    idUser: '',
    isShowTime: false
  }),

  methods: {
    getCalendar() {
      let path = `/doings/${this.month}-${this.partYear}`;
      axios.get(path, {
        headers: {
          Authorization: localStorage.getItem('token')
        }
      })
      .then(response => {
        this.doings = response.data.userTasks
      })
      .catch(e => {
        console.log("ERROR! ha" + e)
      })
    },

    nexT() {
      this.month += 1;
      if(this.month == 13) {
        this.month = 1;
        this.year += 1;
      }
      this.$nextTick(function () {
        this.getCalendar()
      });
      console.log(this.doings);
    },

    bacK() {
      this.month -= 1;
      if(this.month == 0) {
        this.month = 12;
        this.year -= 1;
      }

      this.getCalendar()

      // this.$nexTick(function () {
      //     this.getCalendar()
      // })
      console.log(this.doings);
    },

    whatDoings() {
      console.log(this.doings)
    },

    getUser() {
      axios.get('/user', {
        headers: {
          Authorization: localStorage.getItem('token')
        }
      })
      .then(response => {
        this.idUser = response.data[0].id
      })
      .catch(e => {
        console.log("ERROR! :" + e)
      })
    },

    createDoing() {
      this.isShowTime = !this.isShowTime;
    },

    closeUpdate() {
      this.isShowTime = false;
      this.getCalendar();
    }
  },

  components: {
    Doing, TaskCreate
  },

  computed: {
    partYear() {
      return (this.year + "").substring(2)
    }
  },

  mounted() {
    this.getCalendar();
    this.getUser();
  }

}
</script>

<style lang="css">
  .panel {
    display: flex;
    justify-content: center;
    flex-direction: row;
  }
  .time {
    width: 268px;
    display: flex;
    justify-content: space-evenly;
    margin-left: auto;
  }
  .create {
    width: 40%;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 60px;
    position: relative;
  }
  .create-doing, .current-font {
    font-family: "Mistral";
    font-size: 20pt;
    /* color: rgb(0, 255, 118); */
    color: #FF70A5;
  }
  .bar {
    font-size: 30pt;
  }
  .doings {
    /* display: inline-flex; */
    width: 1065px;
    margin: 0 auto;
  }
  .pos {
    top: 200%;
    right: 20%;
  }
</style>
