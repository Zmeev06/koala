<script setup>
import { defineProps } from "vue";
import { useTaskStore } from "Store/task";
import TaskMain from "./TaskMain.vue";
import Checklist from "./Checklist.vue";
import TaskComments from "./TaskComments.vue";
import TaskAssignee from "./TaskAssignee.vue";
import TaskProjectList from "./TaskProjectList.vue";
import TaskTimer from "./TaskTimer.vue";
import TaskDueDate from "./TaskDueDate.vue";
import TaskFiles from "./TaskFiles.vue";
import TaskTimeCurrent from "./TaskTimeCurrent.vue";
import TaskGradeTime from "./TaskGradeTime.vue";
import TaskCheckbox from "./TaskCheckbox.vue";

const props = defineProps({
  taskId: Number,
  id: Number,
});
const task = useTaskStore();
task.fetch(Number(props.taskId));
</script>

<template>
  <div class="p-1 md:p-2 min-h-full xl:min-h-screen modal-content">
    <div class="bg-white rounded-[10px] w-full min-h-full">
      <div
        class="rounded-lg flex justify-center h-full py-28"
        v-if="task.loading"
      >
        <v-loader size="40" color="text-green-600" />
      </div>
      <div class="h-full flex flex-col" v-else>
        <div
          class="flex shadow-sm rounded-t-lg border-gray-200"
          :style="{
            'background-color': task.data.project
              ? task.data.project.meta.color
              : '#666666',
          }"
        >
          <div class="flex items-center text-white px-3 md:px-6">
            <span
              class="inline-block w-2.5 h-2.5 rounded-full ltr:mr-2 rtl:ml-2 bg-white"
              >&nbsp;</span
            >
            <span>{{
              task.data.project ? task.data.project.name : "Project"
            }}</span>
            <span class="px-2">/</span>
            <span>{{
              task.data.project ? task.data.project_list.name : "Project"
            }}</span>
          </div>
          <span
            class="text-white block ml-auto hover:text-gray-400 cursor-pointer px-4 py-4"
            @click="
              $router.push({ name: 'ProjectsDetail', params: { id: props.id } })
            "
          >
            <svg class="w-6 h-6" viewBox="0 0 21 21">
              <g
                fill="none"
                fill-rule="evenodd"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                transform="translate(5 5)"
              >
                <path d="m10.5 10.5-10-10z" />
                <path d="m10.5.5-10 10" />
              </g>
            </svg>
          </span>
        </div>
        <div
          class="grid xl:grid-cols-[45%_27%_1fr] lg:grid-cols-3 grid-cols-1 min-h-[80vh] gap-6 px-6 md:px-12 py-6"
        >
          <div class="grid grid-cols-1 grid-rows-[1fr_220px] gap-4">
            <TaskMain />
            <TaskFiles />
          </div>
          <div class="flex flex-col gap-4">
            <div class="flex items-center gap-4" v-if="!can('guest:view')">
              <TaskCheckbox />
              <TaskProjectList />
            </div>
            <TaskComments />
          </div>
          <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-2">
              <div
                class="grid grid-cols-[100%] sm:grid-cols-[50%_1fr] xl:grid-cols-[100%] 2xl:grid-cols-[50%_1fr] 3xl:grid-cols-[60%_1fr] gap-3"
              >
                <TaskDueDate />
                <TaskGradeTime v-if="!can('guest:view')" />
                <TaskTimer v-if="!can('guest:view')" />
                <TaskTimeCurrent v-if="!can('guest:view')" />
              </div>
              <TaskAssignee v-if="!can('guest:view')" />
            </div>
            <Checklist />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
