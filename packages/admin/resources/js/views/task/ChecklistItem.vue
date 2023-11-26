<template>
  <div class="relative flex group">
    <!-- <span class="inline-block rounded-full bg-white h-5 w-5 text-white cursor-pointer mt-px border border-gray-300 mr-2">
      <svg viewBox="0 0 16 16" fill="white"><path d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/></svg>
    </span> -->
    <ChecklistItemCheckbox :id="id" :index="index" :is-completed="isCompleted" :is-time="task.data.status_time" />

    <p class="flex-1 text-black text-xs break-all" @click="task.checklistItemForm = index">{{ item }}</p>

    <p class="text-xs ml-1">{{getTime(index) || '00:00:00'}}</p>

    <div v-if="!can('guest:view') || !task.data.id">
      <div class="absolute flex items-center right-0 bg-white pl-4" :class="{ 'opacity-50': processing }" v-if="deleteConfirmation">
        <span class="text-gray-600 text-sm mr-2">Are you sure to delete?</span>
        <CheckCircleIcon class="w-5 h-5 text-green-600 cursor-pointer hover:text-green-800 mr-1" @click="deleteTask"/>
        <XCircleIcon class="w-5 h-5 text-red-600 cursor-pointer hover:text-red-800" @click="deleteConfirmation = false"/>
      </div>

      <div class="absolute hidden group-hover:flex right-0 bg-white pl-4" v-else>
      <span @click="task.checklistItemForm = index" class="mr-1">
        <PencilAltIcon class="w-4 h-4 text-gray-600 cursor-pointer hover:text-gray-900"/>
      </span>
        <TrashIcon class="w-4 h-4 text-gray-600 cursor-pointer hover:text-gray-900" @click="deleteConfirmation = true"/>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { ref } from 'vue'
  import { useTaskStore } from 'Store/task'
  import { useDetailStore } from 'Store/detail'
  import ChecklistItemCheckbox from './ChecklistItemCheckbox.vue'
  import { PencilAltIcon, TrashIcon, XCircleIcon, CheckCircleIcon } from '@heroicons/vue/outline'

  const props = defineProps({
    id: Number,
    index: Number,
    item: String,
    isCompleted: String,
  })

  const task = useTaskStore(),
    deleteConfirmation = ref(false),
    processing = ref(false),
    projectDetail = useDetailStore('project')()

  function deleteTask() {
    if (processing.value) return

    processing.value = true

    axios.delete(`checklist-item/${props.id}`)
      .then(data => {
        processing.value = false
        if (!data.success) return
        task.data.checklists[0].checklist_items.splice(props.index, 1)
        updateProjectDetail()
      })
  }

  function updateProjectDetail() {
    projectDetail.fetch({
      loading: false,
      id: task.data.project_id,
    })
  }

  function getTime(index){
    var timestamp = task.data.checklists[0].checklist_items[index].total_second;
    console.log(timestamp);
    var hours = Math.floor(timestamp / 60 / 60);
    var minutes = Math.floor(timestamp / 60) - (hours * 60);
    var seconds = timestamp % 60;

    return [
      hours.toString().padStart(2, '0'),
      minutes.toString().padStart(2, '0'),
      seconds.toString().padStart(2, '0')
    ].join(':');
  }


</script>
