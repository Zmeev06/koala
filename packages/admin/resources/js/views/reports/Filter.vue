<script setup>
import {ref, defineEmits} from 'vue';
import {useRouter} from "vue-router";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import UsersFilter from './filters/UsersFilter.vue'
import ProjectsFilter from './filters/ProjectsFilter.vue'
import Ordering from './filters/Ordering.vue'
import {useReportsStore} from "../../stores/reports";

const date = ref();
const store = useReportsStore()
const router = useRouter()
const emit = defineEmits(['onFilter'])
</script>

<template>
  <div class="flex items-center gap-4 mb-2 h-10">
      <VueDatePicker class="w-[350px]" placeholder="Период" v-model="store.filters.dates" :enable-time-picker="false" range/>
      <users-filter/>
      <projects-filter/>
      <div
        @click="emit('onFilter')"
        class="h-full px-3 bg-gray-800 text-white flex items-center rounded-[10px] cursor-pointer">
        Поиск
      </div>
  </div>
  <div class="">
    <ordering @on-sort="emit('onFilter')"></ordering>
  </div>
</template>

