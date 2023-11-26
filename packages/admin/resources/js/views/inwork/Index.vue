<template>
  <h2 class="text-2xl font-semibold text-[#424242] mb-4">Задачи в работе</h2>
  <div v-if="data" class="">
    <div class="flex-flex-col">
      <a
        v-for="task in data"
        :href="`/projects/${task.project.id}/tasks/${task.id}`"
        target="_blank"
        class="bg-white min-w-[280px] w-1/4 block rounded shadow-md cursor-pointer mb-4 px-2.5 py-2 flex flex-col gap-2 relative"
      >
        <play-icon class="w-6 h-6 text-green-500 absolute top-1 right-2" />
        <div class="flex items-center gap-2">
          <div
            class="w-2 h-2 rounded-full block"
            :style="'background-color: ' + task.project.meta.color"
          ></div>
          <p class="text-small text-gray-700 leading-5">
            {{ task.project.name }}
          </p>
        </div>
        <div class="flex flex-col gap-1">
          <p class="text-sm font-medium leading-5">{{ task.title }}</p>
          <p class="text-small text-gray-700">
            <span class="text-gray-500">Оценка: </span>
            <span>{{ task.deadline }}&nbsp;мин</span>
          </p>
          <div class="flex items-center py-1" v-show="task.due_at">
            <div
              class="rounded-full px-2 flex items-center justify-center"
              :style="`background-color: ${getDeadlineColor(
                task.human_due_date
              )}`"
            >
              <span
                class="text-xs text-white leading-0"
                v-text="getHumanDate(new Date(task.human_due_date))"
              ></span>
            </div>
          </div>
        </div>
        <div class="flex flex-col gap-1">
          <div v-for="user in task.users" class="flex items-center gap-2">
            <img
              v-show="user.avatar"
              class="rounded-full w-8 h-8 border border-gray-500"
              :src="user.avatar"
              alt="avatar"
              :title="user.name"
            />
            <p class="text-small text-gray-700 leading-5">{{ user.name }}</p>
          </div>
        </div>
      </a>
    </div>
  </div>
  <div v-else class="w-full h-full">
    <v-loader size="24" color="#5850ec" />
  </div>
</template>

<script setup>
import { PlayIcon } from "@heroicons/vue/solid";
import { ClockIcon } from "@heroicons/vue/outline";
import { markRaw, ref } from "vue";
import { useModalStore } from "../../stores/modal";
import axios from "axios";
import TaskModal from "View/task/TaskModal.vue";

const data = ref(null);

axios.get("/api/tasks/inwork").then((res) => {
  data.value = res.data;
});

function openModal(taskId, projectId) {
  const url = `/projects/${projectId}/tasks/${taskId}`;
  history.replaceState(history.state, "", url);
  useModalStore().show(markRaw(TaskModal), { taskId, width: "max-w-3xl" });
}

function getDeadlineColor(date) {
  if (date) {
    let deadline = new Date(date);
    let now = new Date();
    if (deadline - now > 172800000) {
      return "#4DC760";
    }
    if (deadline - now > 0 && now - deadline < 172800000) {
      return "#EEC74A";
    }
    if (deadline - now < 0) {
      return "#D94F4F";
    }
  }
}

function getTime(timer) {
  const hours = (sec) => {
    return Math.floor((sec / 3600) % 24)
      .toString()
      .padStart(2, "0");
  };
  const mins = (sec) => {
    return Math.floor((sec / 60) % 60)
      .toString()
      .padStart(2, "0");
  };
  const secs = (sec) => {
    return (sec % 60).toString().padStart(2, "0");
  };

  return `${hours(timer)}:${mins(timer)}:${secs(timer)}`;
}

function getHumanDate(date) {
  let month = "";
  let day = date.getDate();
  let year = date.getFullYear();
  let h = date.getHours();
  let m = date.getMinutes();
  switch (date.getMonth()) {
    case 0:
      month = "Янв";
      break;
    case 1:
      month = "Фев";
      break;
    case 2:
      month = "Март";
      break;
    case 3:
      month = "Апр";
      break;
    case 4:
      month = "Май";
      break;
    case 5:
      month = "Июнь";
      break;
    case 6:
      month = "Июль";
      break;
    case 7:
      month = "Авг";
      break;
    case 8:
      month = "Сен";
      break;
    case 9:
      month = "Окт";
      break;
    case 10:
      month = "Ноя";
      break;
    case 11:
      month = "Дек";
      break;
  }
  if (h.toString().length < 2) {
    h = `0${h}`;
  }
  if (m.toString().length < 2) {
    m = `0${m}`;
  }

  return `${month} ${day}, ${year} ${h || "00"}:${m || "00"}`;
}
</script>

<style scoped></style>
