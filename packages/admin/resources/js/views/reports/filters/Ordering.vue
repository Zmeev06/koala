<script setup>
import {ref} from 'vue'
import {ArrowDownIcon} from '@heroicons/vue/solid'
import {ArrowUpIcon} from '@heroicons/vue/solid'
import {useReportsStore} from "../../../stores/reports";

const store = useReportsStore()
const emits = defineEmits(['onSort'])
const ordering = ref([
  {
    name: 'updated_at',
    nameOut: 'по дате обновления',
    dir: 'desc',
    active: true
  },
  {
    name: 'completed_at',
    nameOut: 'по дате завершения',
    dir: 'asc',
    active: false
  },
  {
    name: 'time_replicated',
    nameOut: 'по времени выполнения',
    dir: 'asc',
    active: false
  },
])

function onSorting(order) {
  order.dir === 'asc' ? order.dir = 'desc' : order.dir = 'asc'
  ordering.value.map(el => el.active = false)
  order.active = true
  store.filters.order_name = order.name
  store.filters.order_dir = order.dir
  emits('onSort')
}
</script>

<template>
  <div class="flex items-center gap-2 rounded-[10px] overflow-hidden w-max h-full bg-white py-1.5 px-2 mt-4">
    <div
      class="flex items-center gap-1 py-0.5 px-2 rounded-[7px] overflow-hidden cursor-pointer hover:bg-gray-200"
      :class="order.active ? 'bg-gray-600 text-white' : 'bg-white text-gray-800'"
      v-for="order in ordering"
      @click="onSorting(order)"
    >
      <p class="text-sm leading-5">{{order.nameOut}}</p>
      <arrow-up-icon
        :class="order.active ? 'text-white' : 'text-gray-800'"
        class="w-3 h-3"
        v-show="order.dir === 'asc'"/>
      <arrow-down-icon
        :class="order.active ? 'text-white' : 'text-gray-800'"
        class="w-3 h-3"
        v-show="order.dir === 'desc'"/>
    </div>
  </div>
</template>

