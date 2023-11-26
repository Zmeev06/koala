<template>
  <section
    :class="validTime ? 'border-red-500' : ''"
    class="flex items-center rounded-[10px] pl-2 py-1 border border-white gap-1 min-w-[150px]"
  >
    <div class="flex items-end border-b border-gray-500">
      <input
        class="grade-time-input disabled:text-gray-500 text-center task-title block text-end w-full w-[50px] p-0 text-sm border-0 focus:ring-0 resize-none text-gray-800 placeholder:text-gray-500 placeholder:font-normal placeholder:text-sm"
        type="number"
        v-model="grade"
        placeholder="00"
        :disabled="validDisabled ? 'disabled' : false"
      />
      <span class="text-xs text-gray-800">&nbsp;ч.</span>
    </div>

    <p>:</p>
    <div class="flex items-end border-b border-gray-500">
      <input
        class="grade-time-input disabled:text-gray-500 text-center task-title block text-end w-full w-[50px] p-0 text-sm border-0 focus:ring-0 resize-none text-gray-800 placeholder:text-gray-500 placeholder:font-normal placeholder:text-sm"
        type="number"
        v-model="grade2"
        placeholder="00"
        :disabled="validDisabled ? 'disabled' : false"
        @change="validateMinutes"
      />
      <span class="text-xs text-gray-800">&nbsp;мин.</span>
    </div>

    <div class="" v-if="task.data.deadline < 1">
      <v-loader v-if="load" size="16" color="#FFFFFF" />
      <div
        v-else
        @click="save"
        class="cursor-pointer w-5 h-5 hover:scale-[105%]"
      >
        <svg
          class="w-full h-full fill-gray-600"
          xmlns="http://www.w3.org/2000/svg"
          height="1em"
          viewBox="0 0 448 512"
        >
          <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
          <path
            d="M48 96V416c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16V170.5c0-4.2-1.7-8.3-4.7-11.3l33.9-33.9c12 12 18.7 28.3 18.7 45.3V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96C0 60.7 28.7 32 64 32H309.5c17 0 33.3 6.7 45.3 18.7l74.5 74.5-33.9 33.9L320.8 84.7c-.3-.3-.5-.5-.8-.8V184c0 13.3-10.7 24-24 24H104c-13.3 0-24-10.7-24-24V80H64c-8.8 0-16 7.2-16 16zm80-16v80H272V80H128zm32 240a64 64 0 1 1 128 0 64 64 0 1 1 -128 0z"
          />
        </svg>
      </div>
    </div>
  </section>
</template>

<script setup>
import { onBeforeMount, ref, computed } from "vue";
import { useTaskStore } from "Store/task";
import { InboxInIcon } from "@heroicons/vue/outline";

const task = useTaskStore(),
  grade = ref(null),
  grade2 = ref(null),
  load = ref(false),
  validTime = ref(false);

onBeforeMount(() => {
  grade.value = Math.floor(Number(task.data.deadline) / 60);
  grade2.value = Number(task.data.deadline) % 60;
});

const validDisabled = computed(() => {
  return task.data.deadline > 1;
});

function save(e) {
  const minutes = grade.value * 60 + grade2.value;
  if (minutes > 1) {
    axios
      .patch(`tasks/${task.data.id}`, {
        deadline: minutes,
      })
      .then((data) => {
        task.fetch(task.data.id);
      });
  } else {
    validTime.value = true;
    setTimeout(() => {
      validTime.value = false;
    }, 2000);
  }
}

function validateMinutes() {
  if (grade2.value > 60) {
    grade2.value = 60;
  }
}

console.log(task.data.deadline);
</script>

<style>
.grade-time-input .grade-time-input::-webkit-outer-spin-button,
.grade-time-input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
.grade-time-input[type="number"] {
  -moz-appearance: textfield;
}
</style>
