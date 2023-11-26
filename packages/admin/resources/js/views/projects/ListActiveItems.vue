<template>
  <list-active-item
    v-for="task in task.inWork"
    :task="task"
    :key="task.inWork"
    @stop="get()"/>
</template>

<script setup>
  import axios from "axios";
  import {ref} from "vue";
  import {useTaskStore} from "../../stores/task";
  import ListActiveItem from "./ListActiveItem.vue";

  const task = useTaskStore();

  function get() {
    axios({
      method: 'post',
      url: '/api/timer/get-in-work'
    }).then(res => [
      task.inWork = res.data
    ])
  }
  get()
</script>

<style scoped>

</style>
