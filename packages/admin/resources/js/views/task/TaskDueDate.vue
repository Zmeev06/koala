<template>
  <!--  <section class="">-->
  <!--&lt;!&ndash;    <h2 class="text-gray-600 text-sm font-medium px-2">{{ __('Due Date') }}</h2>&ndash;&gt;-->

  <!--    <div class="flex items-center px-6 py-3 rounded-[10px]" data-cooltipz-dir="top" v-if="!can('task:update')">-->
  <!--&lt;!&ndash;      <CalendarIcon class="w-4 h-4 text-gray-500"/>&ndash;&gt;-->
  <!--      <span class="block leading-none text-sm text-semibold text-gray-600">{{ task.data.due_at ? task.data.due_at : __('No due date') }}</span>-->
  <!--    </div>-->

  <!--    <v-dropdown name="task-date" close-outside :close="closeDropdown" :modal="true" class="h-full" v-else>-->
  <!--      <template #trigger>-->
  <!--        <div class="group flex items-center h-full px-3 cursor-pointer border  border-gray-300 hover:bg-gray-200 rounded-[10px]">-->
  <!--&lt;!&ndash;          <CalendarIcon class="w-4 h-4 text-gray-500"/>&ndash;&gt;-->

  <!--          <span class="block text-sm leading-none">{{ task.data.due_at ? task.data.human_due_date : __('No due date') }}</span>-->

  <!--          <span class="flex items-center justify-center ml-auto hover:bg-gray-300 rounded-md w-4 h-4" @click.stop="onDateSelected" v-if="task.data.due_at">-->
  <!--            <XIcon class="w-3.5 h-3.5 text-gray-600"/>-->
  <!--          </span>-->
  <!--        </div>-->
  <!--      </template>-->

  <!--      <div class="ltr:origin-top-left rtl:origin-top-right absolute ltr:left-0 rtl:right-0 mt-2 z-30 border border-gray-300 rounded-[10px]" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">-->
  <!--        <v-calendar :date="task.data.due_at" :time="'14:03'" @selected="onDateSelected"/>-->
  <!--      </div>-->
  <!--    </v-dropdown>-->
  <!--  </section>-->

  <vue-date-picker
    v-model="task.data.due_at"
    time-picker-inline
    model-type="yyyy-MM-dd HH:mm:ss"
    locale="ru"
    month-name-format="long"
    @closed="onDateSelected"
  >
    <template #dp-input>
      <div
        class="cursor-pointer h-8 px-2 py-1 rounded-[8px] border-gray-300 border hover:shadow flex gap-2 items-center"
      >
        <calendar-icon class="w-5 h-5 text-gray-400" />
        <p class="font-normal text-gray-800">{{ task.data.due_at }}</p>
      </div>
    </template>
    <template #action-row="{ selectDate, closePicker }">
      <div class="flex items-center gap-2">
        <button
          class="py-0.5 px-2 bg-white border border-green-400 text-sm rounded-[4px] hover:bg-green-400 hover:text-white transition duration-75"
          @click="selectDate"
        >
          Сохранить
        </button>
        <button
          class="py-0.5 px-2 bg-white border border-red-400 text-sm rounded-[4px] hover:bg-red-400 hover:text-white transition duration-75"
          @click="closePicker"
        >
          Отмена
        </button>
      </div>
    </template>
  </vue-date-picker>
</template>

<script setup>
import { ref, computed } from "vue";
import VDropdown from "Component/Dropdown.vue";
import VCalendar from "Component/Calendar.vue";

import { CalendarIcon, XIcon, ChevronDownIcon } from "@heroicons/vue/outline";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { useTaskStore } from "Store/task";
import { useDetailStore } from "Store/detail";

const closeDropdown = ref(false);
const task = useTaskStore();
const projectDetail = useDetailStore("project")();

function updateProjectDetail() {
  projectDetail.fetch({
    loading: false,
    id: task.data.project_id,
  });
}

function choose(option) {
  task.data.priority = {
    name: option.name,
    color: option.color,
  };

  axios
    .patch("tasks/" + task.data.id + "/priority", {
      priority: option.id,
    })
    .then((data) => {
      console.log(data);
    });
}

function removeDate() {
  console.log("removeDate");
}

const onDateSelected = function () {
  // console.log('onDateSelected')
  // closeDropdown.value = true
  // task.data.due_at = payload ? payload.date : null
  // task.data.human_due_date = payload ? payload.label : null

  axios
    .patch("tasks/" + task.data.id + "/due-date", {
      due_at: task.data.due_at ? task.data.due_at : null,
      // due_time: payload && payload.time ? payload.time+':00' : '00:00:00'
    })
    .then((data) => {
      console.log(data);
      updateProjectDetail();
    });
};
</script>
