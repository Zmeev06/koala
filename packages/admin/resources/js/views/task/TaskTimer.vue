<template>
  <section v-if="isCurrentUserTask && task.data.deadline > 1">
    <div
      @click.stop="stop()"
      class="cursor-pointer bg-white border border-gray-300 outline-1 py-3 outline-[#130032] flex items-center justify-center w-full rounded-[10px]"
      v-if="task.data.status_time == 1"
    >
      <p class="text-[#130032] text-sm font-semibold">Завершить</p>
    </div>
    <div
      @click.stop="start()"
      class="cursor-pointer bg-[#130032] py-3 flex items-center justify-center w-full rounded-[10px]"
      v-else
    >
      <p class="text-white text-sm font-semibold">Начать работу</p>
    </div>
    <p v-if="timerError" class="text-xs text-red-500 mt-2 text-center">
      {{ timerError }}
    </p>
  </section>
  <div
    v-else
    class="bg-gray-400 py-3 lg:py-2 xl:py-3 px-2 flex items-center justify-center w-full rounded-[10px]"
  >
    <p class="text-white text-center leading-5 text-xs font-semibold">
      {{ message }}
    </p>
  </div>
</template>

<script setup>
import axios from "axios";
import { ref, computed } from "vue";
import { useTaskStore } from "Store/task";
import { useTimerStore } from "Store/timer";
import { useDetailStore } from "Store/detail";
import { useIndexStore } from "Store/index";
import { useModalStore } from "Store/modal";
import { PlayIcon, StopIcon } from "@heroicons/vue/outline";

const task = useTaskStore();
const timer = useTimerStore();
const project = useDetailStore();
const projectDetail = useDetailStore("project")();
const isCurrentUserTask = ref(false);
const isSetTime = ref(false);
const tasksIndex = useIndexStore("tasks")();
// const tasksIndex = useIndexStore('tasks')()
const timerError = ref(null);

checkIsCurrentUserTask();

const message = computed(() => {
  if (!isCurrentUserTask.value) {
    return "Вы не можете начать задачу";
  }
  if (task.data.deadline < 1) {
    return "Оцените задачу";
  }
});

function startTimer() {
  timer.start(task.data);
  timer.setTimer(task.data.total_seconds);
  task.data.status_time = 1;
  task.data.completed_at = null;
}

function stopTimer() {
  task.data.completed_at = null;
  task.data.status_time = 0;
  timer.stop(task.data);

  projectDetail.fetch({
    loading: false,
    id: task.data.project_id,
  });
}

function complete() {
  task.data.status_time = 2;
  timer.complete(task.data);

  task.data.completed_at = new Date();
  projectDetail.fetch({
    loading: false,
    id: task.data.project_id,
  });
}

function checkIsCurrentUserTask() {
  timer.taskId = task.data.id;
  timer.projectId = task.data.project_id;

  if (task.data.users.length) {
    if (task.data.status_time == 1) {
      timer.setTimer(task.data.total_seconds);
      timer.startTimer();
    }

    if (task.data.users.find((x) => x.id == Config.user.id)) {
      return (isCurrentUserTask.value = true);
    }
  }

  isCurrentUserTask.value = false;
}

function start() {
  axios({
    method: "post",
    url: "/api/timer/get-in-work",
  }).then((res) => {
    if (res.data.length > 0) {
      timerError.value = "Одна задача уже запущена";
    } else {
      timerError.value = null;
      axios({
        method: "post",
        url: `/api/timer/start`,
        data: {
          id: task.data.id,
        },
      }).then((res) => {
        task.fetch(task.data.id);
      });
    }
  });
}

function stop() {
  axios({
    method: "post",
    url: `/api/timer/stop`,
    data: {
      id: task.data.id,
    },
  }).then((res) => {
    task.fetch(task.data.id);
  });
}
</script>
