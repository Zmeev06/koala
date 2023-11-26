<script setup>
import {ref} from 'vue'
import {useReportsStore} from "../../../stores/reports";
import UserAvatar from 'Component/UserAvatar.vue'
import Dropdown from "../../../components/Dropdown.vue";
import {ChevronDownIcon} from '@heroicons/vue/outline'
import {fetchGetAllUsers} from "../../../api/reportsApi";

const store = useReportsStore()
const props = defineProps(['allUsers'])
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
          v-for="user in props.allUsers"
          :key="user.id"
          :class="store.filters.users_id.includes(user.id) ? 'bg-gray-300' : 'bg-white'"
          class="flex items-center gap-2 cursor-pointer border border-white hover:border-gray-200 rounded-md px-2 py-0.5"
          @click="store.pushId({name:'users_id', value: user.id})">
          <UserAvatar
            data-cooltipz-dir="top"
            :aria-label="user.name"
            class="w-6 h-6 border border-gray-200"
            :user="user"
            :key="user.id"
          />
          <p class="text-sm font-medium">{{ user.name }}</p>
        </div>
      </div>
    </div>
  </dropdown>
</template>
