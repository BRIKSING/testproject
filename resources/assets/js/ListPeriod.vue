<template lang="html">
  <select class="select" v-model="selectedValue" v-on:change="changePeriod()">
    <option v-for="(period, i) in periods" v-bind:value="i+1">{{period[i+1]}}</option>
  </select>
</template>

<script>
import axios from 'axios';

export default {
  data: () => ({
      selectedValue: '',
      periods: []
  }),

  props: [
    'period'
  ],

  methods:{
    getPeriodList() {
      axios.get('/getPeriods')
      .then(response => {
        this.periods = response.data.periods
        this.selectedValue = this.period
      })
      .catch(e => {
        console.log("ERROR! " + e)
      })
    },

    changePeriod() {
      this.$emit('setPeriod', this.selectedValue);
    }
  },

  mounted() {
    this.getPeriodList();
  }
}
</script>

<style lang="css">
</style>
