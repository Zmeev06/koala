<template>
  <span
    class="inline-block rounded-full h-5 w-5 cursor-pointer mr-2"
    :class="{ 'opacity-50': processing, 'bg-[#130032]': isCompleted, 'border border-gray-300 bg-white': !isCompleted }"
    @click="isTime && !isCompleted ? toggle() : false"
  >
    <svg viewBox="0 0 16 16" fill="white"><path d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/></svg>
  </span>
</template>

<script setup>
  import { ref } from 'vue'
  import { useTaskStore } from 'Store/task'
  import { useDetailStore } from 'Store/detail'

  const props = defineProps({
    id: Number,
    index: Number,
    isCompleted: String,
    isTime: Number,
  })

  const task = useTaskStore(),
    projectDetail = useDetailStore('project')(),
    processing = ref(false)

  function toggle() {
    if (processing.value) return

    processing.value = true

    axios.patch(`checklist-item/${props.id}/complete`, {
      // time: task.data.total_seconds + Math.floor(Date.now() / 1000) - task.data.time_replicated
      time: Math.floor(Date.now() / 1000),
      task: task.data.id
    })
      .then(data => {
        console.log(data);
        processing.value = false
        task.data.checklists[0].checklist_items[props.index].completed_at = data.completed_at
        task.data.checklists[0].checklist_items[props.index].total_second = data.time
        updateProjectDetail()
      })
  }

  function updateProjectDetail() {
    projectDetail.fetch({
      loading: false,
      id: task.data.project_id,
    })
  }
</script>
