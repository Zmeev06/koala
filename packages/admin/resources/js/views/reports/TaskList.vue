<template>
  <div class="flex flex-col w-full max-h-[60vh] w-full overflow-y-auto overflow-x-hidden">
    <task v-for="task in tasks" :key="task.id" :task="task"/>
  </div>
</template>

<script setup>
import Task from "./Task.vue";
import {defineProps} from "vue";
const props = defineProps({
  tasks: Array
})

</script>

<style scoped>

</style>
