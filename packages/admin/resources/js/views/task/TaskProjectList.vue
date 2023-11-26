<template>
  <section class="border border-gray-300 rounded-[10px]" v-if="task.data.project_list">
<!--    <h2 class="text-gray-600 text-sm font-medium px-2">{{ __('Project List') }}</h2>-->

    <div class="flex items-center p-3" v-if="!can('task:update')">
      <span class="block leading-none text-xs text-gray-600">
        {{ task.data.project_list.name }}
      </span>
    </div>

    <v-dropdown name="task-priority" :modal="true" v-else>
      <template #trigger>
        <div class="group flex items-center gap-6 cursor-pointer hover:bg-gray-200 rounded-md p-3">
          <span class="block leading-none text-sm text-gray-700 ">{{ task.data.project_list.name }}</span>
          <svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.7529 1L6.75293 7L1.75293 1" stroke="#565656" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </template>

      <div class="ltr:origin-top-left rtl:origin-top-right absolute ltr:left-0 rtl:right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-30" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
        <span v-for="option in task.options.project_lists" class="block px-4 py-2 cursor-pointer text-xs hover:bg-gray-200 text-gray-600" @click="choose(option)">{{ option.name }}</span>
      </div>
    </v-dropdown>
  </section>
</template>

<script setup>
  import VDropdown from 'Component/Dropdown.vue'
  import { useTaskStore } from 'Store/task'
  import { useDetailStore } from 'Store/detail'

  const task = useTaskStore()
  const projectDetail = useDetailStore('project')()

  function updateProjectDetail() {
    projectDetail.fetch({
      loading: false,
      id: task.data.project_id,
    })
  }

  function choose(option) {
    task.data.project_list.name = option.name

    axios.patch(`tasks/${task.data.id}/list`, {
      project_list_id: option.id
    })
      .then(data => {
        updateProjectDetail()
      })
  }
</script>
