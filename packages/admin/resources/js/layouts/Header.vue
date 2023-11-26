<template>
  <div class="ml-[40px] md:m-0 relative z-10 flex-shrink-0 flex h-16">
    <!-- <button
      class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden"
      @click="main.mobileSidebar = true"
    >
      <span class="sr-only">Open sidebar</span>
      <MenuAlt2Icon class="h-6 w-6" aria-hidden="true" />
    </button> -->

    <div class="flex-1 px-4 flex justify-between">
      <div class="flex items-center gap-4 mr-4" id="header-project-info"></div>
      <!--      <div class="flex-1 flex items-center px-4">-->
      <!--        <RecentDropdown/>-->
      <!--        <CreateDropdown class="ltr:ml-6 rtl:mr-6" v-if="can('project:create') || can('user:create')"/>-->
      <!--      </div>-->

      <div
        class="w-1/2 ltr:ml-4 rtl:mr-4 flex justify-end items-center ltr:md:ml-6 rtl:md:mr-6"
      >
        <div class="flex items-center gap-2">
          <p class="text-black text-[28px] font-[300]">
            {{ `${hours}:${minutes > 9 ? minutes : "0" + minutes}` }}
          </p>
        </div>
        <!--        <TimerCurrentUser class="ltr:mr-5 rtl:ml-5"/>-->
        <TimerDropdown v-if="!can('guest:view')" />
        <NotificationsDropdown
          v-if="!can('guest:view')"
          class="ltr:ml-5 rtl:mr-5"
        />

        <ProfileDropdown class="ltr:ml-5 rtl:mr-5" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { MenuAlt2Icon } from "@heroicons/vue/outline";
import { useMainStore } from "Store/main";
import { onBeforeUnmount, ref } from "vue";
import NotificationsDropdown from "./NotificationsDropdown.vue";
import ProfileDropdown from "./ProfileDropdown.vue";
import TimerDropdown from "./TimerDropdown.vue";

const main = useMainStore();
const hours = ref(new Date().getHours());
const minutes = ref(new Date().getMinutes());

const updateCurrentTime = () => {
  hours.value = new Date().getHours();
  minutes.value = new Date().getMinutes();
};

const intervalId = setInterval(updateCurrentTime, 1000);

onBeforeUnmount(() => {
  clearInterval(intervalId);
});
</script>
