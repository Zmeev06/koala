<!-- <template>
  <section class="mt-8">
    <Collapsible open>
      <template #trigger="{ open }">
        <div class="flex items-center pl-3 cursor-pointer">
          <svg viewBox="0 0 16 16" class="w-4 h-4 text-gray-500" :class="{'rotate-[270deg]': !open}"><path d="M14 5.758L13.156 5 7.992 9.506l-.55-.48.002.002-4.588-4.003L2 5.77 7.992 11 14 5.758" fill="currentColor"></path></svg>

          <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Projects') }}</h3>

          <span v-if="!can('guest:view')"
            data-cy="create-project-button-sidebar"
            class="flex items-center justify-center ml-auto mr-2 text-gray-500 hover:bg-gray-700 hover:text-gray-300 rounded 1bg-blue-400 w-6 h-6"
            @click.stop="create"
          >
            <PlusIcon class="h-4 w-4"/>
          </span>
        </div>
      </template>

      <div class="mt-2.5 space-y-1">
        <template v-for="(item, index) in project.items" :key="item.name">
          <router-link :to="`/projects/${item.id}`" custom v-slot="{ navigate, href, route }">
            <a :href="href" @click="navigate" :class="[isActive(route.path) ? 'text-white backdrop-brightness-150' : 'text-gray-200 hover:text-white hover:backdrop-brightness-150', 'group flex items-center px-3 py-2 text-sm font-medium rounded-md']">
              <span class="ltr:ml-1 rtl:mr-1 w-2.5 h-2.5 ltr:mr-4 rtl:ml-4 rounded-full" aria-hidden="true" :style="{ 'background-color': item.meta.color }"></span>
              <span class="truncate flex-1">{{ item.name }}</span>

              <SidebarProjectMenu v-if="!can('guest:view')"
                :id="item.id"
                :index="index"
                :is-favorite="item.is_favorite"
                class="group-hover:block"
                :class="{ 'hidden': currentIndex != index }"
                @toggleMenu="onToggle"
              />
            </a>
          </router-link>
        </template>
      </div>
    </Collapsible>
  </section>
</template> -->

<template>
  <div class="w-[90%]">
    <div
      class="flex cursor-pointer items-center h-[24px] w-fit"
      @click="clickHandler"
    >
      <div
        class="flex w-fit duration-300 items-center justify-between"
        :class="props.isOpenSidebar ? 'translate-x-0' : 'translate-x-[-80%]'"
      >
        <ViewGrid color="#BEDCFD" class="mr-3" v-show="props.isOpenSidebar" />
        <div class="w-fit overflow-hidden">
          <p
            class="text-[#FEFEFE] text-sm duration-300"
            :class="
              props.isOpenSidebar ? 'translate-x-0' : 'translate-x-[-100%]'
            "
          >
            Проекты
          </p>
        </div>
        <svg
          width="16"
          height="16"
          viewBox="0 0 16 16"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
          :class="isOpen && 'rotate-180'"
        >
          <path
            d="M7.97147 10.3265C7.74236 10.6538 7.25764 10.6538 7.02853 10.3265L4.63387 6.90553C4.36687 6.5241 4.63974 6 5.10534 6L9.89466 6C10.3603 6 10.6331 6.5241 10.3661 6.90553L7.97147 10.3265Z"
            fill="#FEFEFE"
          />
        </svg>
        <span
          v-if="!can('guest:view') && props.isOpenSidebar"
          data-cy="create-project-button-sidebar"
          class="flex items-center justify-center ml-3 mr-2 text-gray-500 hover:bg-gray-700 hover:text-gray-300 rounded 1bg-blue-400 w-6 h-6"
          @click.stop="create"
        >
          <PlusIcon class="h-4 w-4" />
        </span>
      </div>
    </div>
    <div class="mt-[8px] pl-1" v-if="isOpen">
      <div
        v-for="(item, index) in project.items"
        :key="index"
        class="h-[30px] flex justify-between"
      >
        <RouterLink
          :to="`/projects/${item.id}`"
          custom
          v-slot="{ navigate, href, route }"
          v-if="isOpen"
        >
          <a :href="href" @click="navigate">
            <div
              :class="
                isOpen
                  ? 'translate-y-[0px] opacity-100'
                  : 'translate-y-[-100%] opacity-0'
              "
              class="duration-300 flex gap-[15px] items-center"
            >
              <RoundSvg
                :color="
                  myRoute.path === `/projects/${item.id}`
                    ? '#31B492'
                    : '#FEFEFE'
                "
                class="cursor-pointer"
              />
              <div class="w-[85%] overflow-hidden">
                <p
                  class="cursor-pointer duration-300 overflow-hidden max-w-[215px] whitespace-nowrap text-[14px]"
                  :class="`
                    ${
                      props.isOpenSidebar
                        ? 'translate-x-0'
                        : 'translate-x-[-100%]'
                    } ${
                    myRoute.path === `/projects/${item.id}`
                      ? 'text-[#31B492]'
                      : 'text-[#FEFEFE]'
                  }`"
                >
                  {{ item.name }}
                </p>
              </div>
            </div>
          </a>
        </RouterLink>
        <SidebarProjectMenu
          :id="item.id"
          :index="index"
          class="group-hover:block"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { useModalStore } from "Store/modal";
import { useProjectStore } from "Store/project";
import ProjectForm from "View/projects/Form.vue";
import { computed, markRaw, ref } from "vue";
import { RouterLink, useRoute, useRouter } from "vue-router";
import RoundSvg from "../assets/icons/RoundSvg.vue";
import SidebarProjectMenu from "./SidebarProjectMenu.vue";
import { PlusIcon } from "@heroicons/vue/outline";
import ViewGrid from "../assets/ViewGrid.vue";

const props = defineProps({
  isOpenSidebar: Boolean,
});
const isOpen = ref(true);

const clickHandler = () => {
  isOpen.value = !isOpen.value;
};

const myRoute = useRoute();
console.log(myRoute.path);

const project = useProjectStore(),
  router = useRouter(),
  path = computed(() => router.currentRoute.value.path),
  currentIndex = ref(null);

project.fetch();

function create() {
  useModalStore().show(markRaw(ProjectForm));
}

function isActive(href) {
  return path.value.startsWith(href);
}

function onToggle(data) {
  if (data.state) {
    currentIndex.value = data.index;
  } else if (currentIndex.value == data.index) {
    currentIndex.value = null;
  }
}
</script>
