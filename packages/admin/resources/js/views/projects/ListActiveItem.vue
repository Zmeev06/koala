<template>
  <div class="">
    <div class="border rounded-[7px] px-2 py-2 bg-white/10 flex items-center gap-2"
    :style="`border-color: ${getDeadlineColor(task.due_at)}`">
      <p @click="openModal(task.id)"
        class="text-[12px] text-white max-w-[150px] text-ellipsis whitespace-nowrap overflow-hidden hover:underline cursor-pointer">{{task.title}}</p>
      <div @click="stop()"
        class="cursor-pointer group">
        <svg class="stroke-white group-hover:stroke-red-600 fill-transparent" width="19" height="19" viewBox="0 0 19 19" xmlns="http://www.w3.org/2000/svg">
          <circle cx="9.5" cy="9.5" r="8.90625"  stroke-width="1.1875"/>
          <rect x="6.45517" y="6.45517" width="6.08974" height="6.08974" stroke-width="1.21795"/>
        </svg>
      </div>
    </div>
  </div>
</template>

<script setup>
  import {defineProps, markRaw} from "vue";
  import TaskModal from '../task/TaskModal.vue'
  import { useModalStore } from 'Store/modal'
  import axios from "axios";

  const props = defineProps({
    task: Object
  })

  const emit = defineEmits(['stop'])

  function openModal(id = null) {
    const url = `/projects/${props.task.project_id}/tasks/${props.task.id}`
    history.replaceState(history.state, '', url)
    useModalStore().show(markRaw(TaskModal), {id, width: 'max-w-3xl'})
  }

  function stop() {
    axios({
      method: 'post',
      url: `/api/timer/stop`,
      data: {
        id: props.task.id
      }
    }).then(res => {
      window.location.reload()
    })
  }

  function getDeadlineColor(date){
    if (date) {
      let deadline = new Date(date)
      let now = new Date();
      if (deadline - now > 172800000) {
        return '#4DC760'
      }
      if (deadline - now > 0 && now - deadline < 172800000) {
        return '#EEC74A'
      }
      if (deadline - now < 0) {
        return '#D94F4F'
      }
      if(!data){
        return '#FFFFFF'
      }
    }
  }

</script>

<style scoped>

</style>
