<template>
  <div>
      <Header></Header>
      <div class="ahah">
          <router-view/>
      </div>
  </div>
</template>

<script>
import Header from './Header.vue';

export default {
    // data: () => ({
    //
    // }),

    components: {
      Header
    }
}
</script>

<style scoped>
  p {
    font-size: 2em;
    text-align: center;
  }
  .ahah {
      width: 100%;
      height: 500px;
  }
</style>
