<template>
  <!--  <div id="list-item" -->
  <!--       :data-id="task.id" class="bg-white block rounded shadow-md cursor-pointer px-2.5 py-1 mb-2" -->
  <!--       @click="openModal(task.id)">-->
  <div
    id="list-item"
    :data-id="task.id"
    class="bg-white block rounded shadow-md cursor-pointer px-2.5 py-1 mb-2"
    @click="openTaskWindow()"
  >
    <div class="flex py-1.5">
      <span
        class="flex-1 block text-small"
        :class="{
          'text-gray-500 line-through': task.completed_at,
          'text-gray-700': !task.completed_at,
        }"
        v-text="task.title"
      ></span>
      &nbsp;
      <span class="inline" v-if="task.status_time == 1">
        <StopIcon
          class="w-[0.875rem] h-[0.875rem] text-red-500 hover:text-red-800"
        />
      </span>

      <!-- <div v-show="isCurrentUserTask">
        <span @click.stop="timer.stop" v-if="task.id == timer.taskId">
          <StopIcon class="w-4 h-4 text-red-500 hover:text-red-800"/>
        </span>
        <span @click.stop="timer.start(task)" v-else>
          <PlayIcon class="w-4 h-4 text-gray-500 hover:text-gray-800"/>
        </span>
      </div> -->
    </div>

    <div class="text-start" v-if="!can('guest:view')">
      <task-time-current :task="task" />
    </div>

    <div class="flex items-center gap-2">
      <div
        v-if="!can('guest:view')"
        class="flex items-center gap-1 justify-center"
      >
        <svg
          width="14"
          height="14"
          viewBox="0 0 22 22"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
        >
          <mask
            id="mask0_902_169"
            style="mask-type: alpha"
            maskUnits="userSpaceOnUse"
            x="0"
            y="0"
            width="22"
            height="22"
          >
            <rect width="21.9604" height="21.8829" fill="url(#pattern199)" />
          </mask>
          <g mask="url(#mask0_902_169)">
            <rect
              x="-4.62354"
              y="-4.03046"
              width="32.9405"
              height="29.3691"
              fill="#9CA3AF"
            />
          </g>
          <defs>
            <pattern
              id="pattern199"
              patternContentUnits="objectBoundingBox"
              width="1"
              height="1"
            >
              <use
                xlink:href="#image0_902_169"
                transform="matrix(0.00195312 0 0 0.00196004 0 -0.001771)"
              />
            </pattern>
            <image
              id="image0_902_169"
              width="512"
              height="512"
              xlink:href="data:image/png;base64,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"
            />
          </defs>
        </svg>

        <span class="text-[11px] text-gray-500 leading-0">{{
          task.deadline > 0 ? getDeadlineTime : "-"
        }}</span>
      </div>
      <div class="flex items-center" v-show="task.comments.length">
        <ChatIcon class="w-4 h-4 text-gray-400" />
        <span
          class="ltr:ml-1 rtl:mr-1 text-xs text-gray-500"
          v-text="task.comments.length"
        ></span>
      </div>
      <div
        class="flex items-center"
        v-if="
          task.checklists.length ? task.checklists[0].checklist_items.length : 0
        "
      >
        <CheckCircleIcon class="w-4 h-4 text-gray-400" />
        <span
          class="ltr:ml-0.5 rtl:mr-0.5 text-[11px] font-medium tracking-widest"
          :class="compareCheckList(task.checklists)"
          v-text="countChecklistItems(task.checklists)"
        ></span>
      </div>
    </div>

    <div class="flex items-center">
      <div class="flex items-center gap-1">
        <div class="flex items-center py-1" v-if="task.recurring_at">
          <span
            :aria-label="task.meta.recurring.phrase"
            data-cooltipz-dir="right"
            data-cooltipz-size="medium"
          >
            <RefreshIcon class="w-4 h-4 text-gray-400" />
          </span>
        </div>
        <div class="flex items-center py-1" v-show="task.due_at">
          <!--          <CalendarIcon class="w-4 h-4 text-gray-400"/>-->
          <div
            class="rounded-full px-2 flex items-center justify-center"
            :style="`background-color: ${getDeadlineColor(
              task.human_due_date
            )}`"
            v-show="!props.task.completed_at"
          >
            <span
              class="text-xs text-white leading-0"
              v-text="getHumanDate(new Date(task.human_due_date))"
            ></span>
          </div>
        </div>
      </div>

      <div
        class="ltr:ml-auto rtl:mr-auto flex items-center py-1"
        v-if="task.users.length"
      >
        <span v-show="checkIsCurrentUserTask()"></span>
        <img
          v-show="task.users[0].avatar"
          class="rounded-full w-4 h-4"
          :src="task.users[0].avatar"
          alt="avatar"
          :title="task.users[0].name"
        />

        <span
          v-show="!task.users[0].avatar"
          :title="task.users[0].name"
          class="inline-block rounded-full overflow-hidden bg-gray-100 text-gray-300 w-4 h-4"
        >
          <svg fill="currentColor" viewBox="0 0 24 24">
            <path
              d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"
            />
          </svg>
        </span>

        <span
          class="text-gray-600 text-[9px] ltr:ml-px rtl:mr-px"
          v-show="task.users.length > 1"
          >+{{ task.users.length - 1 }}</span
        >
      </div>
    </div>

    <div class="flex flex-wrap mt-1" v-if="task.labels.length">
      <span
        class="inline-flex items-center px-1.5 py-1 rounded-md text-[10px] leading-none font-semibold ltr:mr-1 rtl:ml-1 mb-1 text-white"
        :style="{ 'background-color': label.meta.color }"
        v-for="label in task.labels"
        :key="label.id"
      >
        {{ label.name }}
      </span>
    </div>

    <!--    <div class="flex items-center mt-1.5 mb-1.5" >-->

    <!--      <p class="text-red-600 text-xs ml-1">-->
    <!--        {{ timer.currentTaskTimer.h.toString().padStart(2, '0') }}:{{ timer.currentTaskTimer.m.toString().padStart(2, '0') }}:{{ timer.currentTaskTimer.s.toString().padStart(2, '0') }}-->
    <!--      </p>-->
    <!--    </div>-->
  </div>
</template>

<script setup>
import { ref, markRaw, computed } from "vue";
import TaskModal from "View/task/TaskModal.vue";
import TaskTimeCurrent from "View/task/TaskTimeCurrent.vue";
import { useModalStore } from "Store/modal";
import { useTimerStore } from "Store/timer";
import {
  CalendarIcon,
  CheckCircleIcon,
  ChatIcon,
  PlayIcon,
  StopIcon,
  RefreshIcon,
} from "@heroicons/vue/outline";
import { useRouter } from "vue-router";

const props = defineProps({
  task: "",
});

const processing = ref(false);
const timer = useTimerStore();
const isCurrentUserTask = ref(false);
const router = useRouter();

function openTaskWindow() {
  const r = router.resolve({
    name: "TaskWindow",
    params: {
      taskId: props.task.id,
    },
  });
  window.open(r.href);
}

function taskComplete(id) {
  processing.value = true;

  axios.patch(`tasks/${id}/complete`).then((data) => {
    processing.value = false;
    props.task.completed_at = data.completed_at;
  });
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

const getDeadlineTime = computed(() => {
  let str1 = Math.floor(Number(props.task.deadline) / 60);
  let str2 = Number(props.task.deadline) % 60;
  return `${str1.toString().padStart(2, "0")}:${str2
    .toString()
    .padStart(2, "0")}`;
});

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

function openModal(id = null) {
  const url = `/projects/${props.task.project_id}/tasks/${id}`;
  history.replaceState(history.state, "", url);

  useModalStore().show(markRaw(TaskModal), {
    id: parseInt(id),
    width: "max-w-3xl",
  });
}

function countSubTasks(tasks) {
  return (
    tasks.filter((x) => x.completed_at != null).length + "/" + tasks.length
  );
}

function countChecklistItems(items) {
  return (
    items[0].checklist_items.filter((x) => x.completed_at != null).length +
    "/" +
    items[0].checklist_items.length
  );
}

function compareCheckList(items) {
  return items[0].checklist_items.filter((x) => x.completed_at != null)
    .length === items[0].checklist_items.length
    ? "text-green-600"
    : "text-red-700";
}

function handleTimer() {
  console.log("handleTimer!");
}

function checkIsCurrentUserTask() {
  if (props.task.users.length) {
    if (props.task.users.find((x) => x.id == Config.user.id)) {
      return (isCurrentUserTask.value = true);
    }
  }

  isCurrentUserTask.value = false;
}

checkIsCurrentUserTask();
</script>
