<template>
  <v-detail name="project" uri="projects" v-slot="{ model }">
    <div class="flex flex-col h-full">
      <div class="flex items-center">
        <Teleport to="#header-project-info">
          <div class="flex items-center">
            <span
              class="block w-2.5 h-2.5 rounded-full ltr:mr-3 ml-0 md:rtl:ml-3"
              :style="{ 'background-color': model.meta.color }"
            ></span>
            <h1
              class="text-md md:text-lg lg:text-2xl font-semibold text-[#424242]"
              data-cy="page-title"
            >
              {{ model.name }}
            </h1>
          </div>

          <span
            class="hidden md:flex text-white group items-center px-3 py-2 rounded-md cursor-pointer hover:backdrop-brightness-150"
            :class="{ 'ring-2 ring-[#C22991]': tab.active == 0 }"
            @click="tab.select(0)"
          >
            <ViewBoardsIcon class="w-4 h-4 text-[#424242]" />
            <span
              class="ltr:ml-2 rtl:mr-2 text-sm font-medium text-[#424242]"
              >{{ __("Board") }}</span
            >
          </span>

          <!-- <span
            class="text-white group flex items-center px-3 py-2 rounded-md cursor-pointer hover:backdrop-brightness-150"
            :class="{ 'ring-2 ring-[#C22991]': tab.active == 1 }"
            @click="tab.select(1)"
          >
            <ClockIcon class="w-4 h-4 text-[#424242]" />
            <span
              class="ltr:ml-2 rtl:mr-2 text-sm font-medium text-[#424242]"
              >{{ __("Time Logs") }}</span
            >
          </span> -->

          <!--          <button @click="onStopAll()">СТОП</button>-->

          <!--          <div class="flex flex-shrink-0 -space-x-1">-->
          <!--            <UserAvatar-->
          <!--              class="rounded-full max-w-none h-6 w-6 rounded-full ring-2 ring-white"-->
          <!--              :user="user"-->
          <!--              v-for="user in detail.data.users"-->
          <!--              data-cooltipz-dir="bottom"-->
          <!--              :aria-label="user.name"-->
          <!--            />-->
          <!--          </div>-->
          <list-active-items v-if="route.name != 'ProjectsDetailTask'" />
        </Teleport>
        <!--        <DetailMenu :project-id="detail.data.id" :is-favorite="detail.data.is_favorite"/>-->
      </div>

      <Component :is="tab.tab" />
    </div>
  </v-detail>
</template>

<script setup>
import { markRaw, onUpdated } from "vue";
import { useDetailStore } from "Store/detail";
import { useTabStore } from "Store/tab";
import TabBoard from "./TabBoard.vue";
import TabTimeLogs from "./TabTimeLogs.vue";
import DetailMenu from "./DetailMenu.vue";
import ListActiveItems from "./ListActiveItems.vue";
import { ViewBoardsIcon, ClockIcon } from "@heroicons/vue/outline";
import UserAvatar from "Component/UserAvatar.vue";
import TaskModal from "View/task/TaskModal.vue";
import { useModalStore } from "Store/modal";
import { useRoute } from "vue-router";

const props = defineProps({
  id: String,
  taskId: String,
});
const route = useRoute();

const tab = useTabStore("project-detail")();

tab.tabs([
  { component: markRaw(TabBoard), label: "Board" },
  { component: markRaw(TabTimeLogs), label: "Time Logs" },
]);

const detail = useDetailStore("project")();

onUpdated(function () {
  detail.fetch();
});

function openModal(id = null) {
  useModalStore().show(markRaw(TaskModal), {
    id: parseInt(id),
    width: "max-w-3xl",
  });
}

function onStopAll() {
  axios.get("/tasks/stop-all-tasks");
}

if (props.taskId) {
  openModal(props.taskId);
}
</script>
