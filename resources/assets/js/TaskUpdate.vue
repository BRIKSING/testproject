<template lang="html">
  <div class="show-time current-font pos">
    <label><span>Name</span><input type="text" class="from-element" v-model="taskName"/></label>
    <label><span>Description</span><input type="text" class="from-element" v-model="taskDesc"/></label>
    <label><span>Period</span><ListPeriod v-bind:period="taskPeriod"></ListPeriod></label>
    <label v-if="taskIsCreate"><span>Date</span><input type="text" class="from-element" v-model="taskDate"/></label>
    <button @click="UpdateTask()"><slot></slot></button>
  </div>
</template>

<script>
import axios from 'axios';
import ListPeriod from './ListPeriod.vue';

export default {
  data: () => ({
    taskName: '',
    taskDesc: '',
    taskPeriod: '',
    taskID: '',
    taskDate: '',
    taskIsCreate: false
  }),

  props: [
    'name', 'description', 'period', 'id', 'date', 'isCreate'
  ],

  components: {
    ListPeriod
  },

  methods: {
    UpdateTask() {
      let path = this.taskIsCreate ? '/TaskCreate' : '/TaskUpdate';
      axios.post(path, {
        name: this.taskName,
        description: this.taskDesc,
        period_id: this.taskPeriod,
        id: this.taskID,
        date: this.taskDate
      }, {
        headers: {
          Authorization: localStorage.getItem('token')
        }
      })
      .then(response => {
        console.log(response.data);
        let on = this.taskIsCreate ? 'closeUpdCalendar' : 'closeUp';
        this.$emit(on);
      })
      .catch(e => {
        console.log("ERROR! " + e)
      })
    }
  },

  mounted() {
    this.taskName = this.name ? this.name : '' ;
    this.taskDesc = this.description ? this.description : '' ;
    this.taskPeriod = this.period ? this.period : '' ;
    this.taskID = this.id ? this.id : '' ;
    this.taskDate = this.date ? this.date : '' ;
    this.taskIsCreate = this.isCreate ? this.isCreate : false;
  }

}
</script>

<style lang="css">
  .show-time {
    width: 300px;
    height: 200px;
    z-index: 50;
    position: relative;
    background-color: rgb(19, 83, 119);
    border: 1px solid #FF70A5
  }
</style>
