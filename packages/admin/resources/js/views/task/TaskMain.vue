<template>

    <div class="flex flex-col gap-4">
<!--      <TaskContentForm v-if="task.isContentForm"/>-->
<!--      <TaskContent v-else/>-->

<!--        <TaskTitleForm v-if="task.isContentFormTitle"/>-->
<!--        <TaskTitle v-else/>-->

        <TaskDescForm/>


    </div>

</template>

<script setup>
  import { useTaskStore } from 'Store/task'
  import TaskContent from './TaskContent.vue'
  import TaskContentForm from './TaskContentForm.vue'
  import TaskTitleForm from './TaskTitleForm.vue'
  import TaskTitle from './TaskTitle.vue'
  import TaskDescForm from './TaskDescForm.vue'
  import TaskDesc from './TaskDesc.vue'

  const task = useTaskStore()
</script>
