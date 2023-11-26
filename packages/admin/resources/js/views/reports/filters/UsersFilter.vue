<script setup>
import UserFilterList from './UsersFilterList.vue'
import {fetchGetAllUsers} from "../../../api/reportsApi";
import {useReportsStore} from "../../../stores/reports";
import {ref} from "vue";

const users = ref(null)
const store = useReportsStore()

function getAllUsers() {
  fetchGetAllUsers().then(res => {
    users.value = res.data
  })
}

getAllUsers()
</script>

<template>
  <div class="bg-white h-full min-w-[280px] w-[280px] rounded-[4px] flex gap-2 relative">
    <div class="w-[90%] max-w-[90%] flex items-center pl-3">
      <svg xmlns="http://www.w3.org/2000/svg" height="0.9em" class="fill-gray-400 mr-2" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>
      <div v-if="store.filters.users_id.length > 0" class="w-full overflow-hidden flex items-center">
        <div
          v-for="(user, i) in users.filter(el => store.filters.users_id.includes(el.id))"
          class="border border-white w-6 h-6 rounded-full overflow-hidden bg-gray-200"
          :class="i === 0 ? '' : '-ml-2'">
          <img :src="user.avatar" class="w-full h-full object-cover" alt="">
        </div>
      </div>
      <p v-else class="text-gray-500 font-light text-[16px]">Пользователи</p>
    </div>
    <div class="absolute top-0 w-full h-full cursor-pointer">
      <user-filter-list :all-users="users" />
    </div>
  </div>
</template>


