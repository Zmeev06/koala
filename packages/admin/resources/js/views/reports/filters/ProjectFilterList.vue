<script setup>
import {ref} from 'vue'
import Dropdown from "../../../components/Dropdown.vue";
import {ChevronDownIcon} from '@heroicons/vue/outline'
import {useReportsStore} from "../../../stores/reports";
import {fetchGetAllProjects} from "../../../api/reportsApi";

const store = useReportsStore()
const props = defineProps(['allProjects'])

</script>

<template>

  <dropdown name="users-list" close-outside>
    <template #trigger>
      <div class="absolute top-0 flex w-full pt-3 pr-2 justify-end">
        <span class="cursor-pointer flex items-center">
          <ChevronDownIcon class="h-4 w-4 text-gray-500"/>
        </span>
      </div>
    </template>

    <div class="absolute right-0 top-10 mt-2 w-full rounded-md shadow-lg py-3 px-3 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-40" role="menu" aria-orientation="vertical" aria-labelledby="users-menu">
      <div class="flex flex-col gap-1 max-h-[300px] overflow-y-auto">
        <div
          class="flex items-center gap-2 cursor-pointer border border-white hover:border-gray-200 rounded-md px-2 py-0.5"
          :class="store.filters.projects_id.includes(project.id) ? 'bg-gray-300' : 'bg-white'"
          v-for="project in props.allProjects"
          @click="store.pushId({name:'projects_id', value: project.id})">
          <div class="w-2 h-2 rounded-full" :style="'background-color: ' + project.meta.color"></div>
          <p class="text-sm font-medium">{{ project.name }}</p>
        </div>
      </div>
    </div>
  </dropdown>
</template>
