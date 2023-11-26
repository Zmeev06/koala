<script setup>
import {computed} from "vue";
const props = defineProps(['data'])
const timeGraded = computed(() => {
  let h = Math.trunc(props.data.tasks_graded/60)
  let m = props.data.tasks_graded % 60
  return [h, m]
})
const timeWorked = computed(() => {
  let h = Math.trunc(props.data.task_worked/3600)
  let m = Math.trunc(props.data.task_worked % 3600 / 60)
  return [h, m]
})
const timeDelta = computed(() => {
  let h = Math.trunc((props.data.tasks_graded * 60 - props.data.task_worked)/3600)
  let m = Math.trunc((props.data.tasks_graded * 60 - props.data.task_worked) % 3600 / 60)
  return [h, m]
})
</script>

<template>
  <div class="" v-if="props.data">
    <p>Всего: {{props.data.tasks_all}}</p>
    <p>Сделано/не сделано: {{props.data.tasks_done}} / {{props.data.tasks_all - props.data.tasks_done}}</p>
    <p>Оценка/факт: {{timeGraded[0]}}:{{timeGraded[1]}} / {{timeWorked[0]}}:{{timeWorked[1]}}. Расхождение: {{timeDelta[0]}}</p>
  </div>
</template>
