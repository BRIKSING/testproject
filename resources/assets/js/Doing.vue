<template lang="html">
  <div class="doing">
    <div class="day">{{this.day}}</div>
    <div v-for="task in this.doings" class="info">
      <div class="day-element" @click="showTime(task)">{{task.name}}</div>
      <div v-if="isShow && !isCurrentUser(task)" class="show-time current-font">
        <div class="from-element">{{task.name}}</div>
        <div class="from-element">{{task.description}}</div>
        <div class="from-element">{{task.period}}</div>
      </div>
      <TaskUpdate
        v-if="isShow && isCurrentUser(task)"
        v-bind:name = "task.name"
        v-bind:description = "task.description"
        v-bind:period = "task.period"
        v-bind:id = "task.id"
        v-bind:date = "task.date"
        v-on:closeUp = "closeUpdate(task)"
      >Изменить</TaskUpdate>
    </div>
  </div>
</template>

<script>
import TaskUpdate  from './TaskUpdate.vue';

export default {
  data: () => ({
    obj: '',
    day: '',
    name: '',
    description: '',
    period: '',
    isShow: false
    //isCurrentUser: false
  }),

  components: {
    TaskUpdate
  },

  props: [
    'objDoing', 'dayDoing', 'userID'
  ],

  computed: {
    doings() {
      let dos = []
      let i = -1
      for (let item in this.parseDoings) {
        dos.push({});
        i++;
        let p = this.parseDoings[item];
        console.log(this);
        dos[i]['name'] = p.name ? p.name : "s";
        dos[i]['description'] = p.description ? p.description : "s";
        dos[i]['date'] = p.date ? p.date : "s";
        dos[i]['period'] = p.period_id;
        dos[i]['userID'] = p.user_id;
        dos[i]['id'] = p.id;
        dos[i]['isShowTime'] = false;
      }
      return dos;
    },

    currentUser() {
      return this.userID
    },

    parseDoings() {
      return this.objDoing
    }

  },

  methods: {
    showTime(task) {
      this.isShow = !task.isShowTime;
      task.isShowTime = !task.isShowTime;
    },

    isCurrentUser(task) {
      //console.log(this);
      return task.userID == this.currentUser;
    },

      closeUpdate(task) {
      this.isShow = false;
      if(task)
        task.isShowTime = false;
      this.$emit('updateCalendar');
    }
  },

  mounted() {
    this.day = this.dayDoing
  }
}
</script>

<style lang="css">
  .doing {
    border: 1px solid rgb(101, 36, 124);
    display: inline-flex;
    flex-direction: column;
    width: 150px;
    height: 100px;
  }

  .from-element {
    padding: 5px;
  }

  .day-element {
    color: rgb(19, 83, 119);
  }
  .day-element:hover {
    color: rgb(36, 145, 207);
  }

</style>
