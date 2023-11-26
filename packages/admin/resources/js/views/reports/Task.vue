<template>
  <div @click="openTaskWindow()" class="flex flex-col gap-0.5 py-2 mx-3 border-b border-gray-200 w-full relative cursor-pointer hover:bg-gray-300">
    <div class="flex items-center gap-2">
      <div class="w-2 h-2 rounded-full overflow-hidden" :style="{'background-color': props.task.project.meta.color}"></div>
      <p class="text-xs text-gray-500">{{props.task.project.name}}</p>
    </div>
    <div class="">
      <span class="text-sm text-gray-800">{{props.task.title}}</span>
      <span class="ml-2 inline rounded-[10px] px-2 py-0.5 text-xs text-white" :style="{'background-color': props.task.project_list.color}">
        {{ props.task.project_list.name }}
      </span>
    </div>
    <div class="flex items-center gap-4">
      <div class="flex gap-1 items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="fill-gray-400" height="0.75em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M176 0c-17.7 0-32 14.3-32 32s14.3 32 32 32h16V98.4C92.3 113.8 16 200 16 304c0 114.9 93.1 208 208 208s208-93.1 208-208c0-41.8-12.3-80.7-33.5-113.2l24.1-24.1c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L355.7 143c-28.1-23-62.2-38.8-99.7-44.6V64h16c17.7 0 32-14.3 32-32s-14.3-32-32-32H176zM288 204c28.7 0 52 23.3 52 52v96c0 28.7-23.3 52-52 52s-52-23.3-52-52V256c0-28.7 23.3-52 52-52zm-12 52v96c0 6.6 5.4 12 12 12s12-5.4 12-12V256c0-6.6-5.4-12-12-12s-12 5.4-12 12zM159.5 244c-5.4 0-10.2 3.5-11.9 8.6l-.6 1.7c-3.5 10.5-14.8 16.1-25.3 12.6s-16.1-14.8-12.6-25.3l.6-1.7c7.2-21.5 27.2-35.9 49.8-35.9c29 0 52.5 23.5 52.5 52.5v2.2c0 13.4-4.9 26.4-13.8 36.4l-39 43.9c-6.2 7-10 15.7-10.9 24.9H192c11 0 20 9 20 20s-9 20-20 20H128c-11 0-20-9-20-20V368.3c0-20.6 7.5-40.4 21.2-55.8l39-43.9c2.4-2.7 3.7-6.2 3.7-9.8v-2.2c0-6.9-5.6-12.5-12.5-12.5z"/></svg>
        <p v-if="props.task.deadline">{{timeGraded[0]}}:{{timeGraded[1]}}</p>
      </div>
      <div class="flex gap-1 items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="fill-gray-400"  height="0.75em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M32 0C14.3 0 0 14.3 0 32S14.3 64 32 64V75c0 42.4 16.9 83.1 46.9 113.1L146.7 256 78.9 323.9C48.9 353.9 32 394.6 32 437v11c-17.7 0-32 14.3-32 32s14.3 32 32 32H64 320h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V437c0-42.4-16.9-83.1-46.9-113.1L237.3 256l67.9-67.9c30-30 46.9-70.7 46.9-113.1V64c17.7 0 32-14.3 32-32s-14.3-32-32-32H320 64 32zM96 75V64H288V75c0 19-5.6 37.4-16 53H112c-10.3-15.6-16-34-16-53zm16 309c3.5-5.3 7.6-10.3 12.1-14.9L192 301.3l67.9 67.9c4.6 4.6 8.6 9.6 12.1 14.9H112z"/></svg>
        <p v-if="props.task.deadline">{{timeWorked[0]}}:{{timeWorked[1]}}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
  import {useRouter} from "vue-router";
  import {computed} from "vue";

  const router = useRouter()
  const props = defineProps({
    task: Object
  })

  const timeGraded = computed(() => {
    let h = Math.trunc(props.task.deadline/60).toString().padStart(2, '0')
    let m = Math.trunc(props.task.deadline % 60).toString().padStart(2, '0')
    return [h, m]
  })
  const timeWorked = computed(() => {
    let h = Math.trunc(props.task.time_replicated/3600).toString().padStart(2, '0')
    let m = Math.trunc(props.task.time_replicated % 3600 / 60).toString().padStart(2, '0')
    return [h, m]
  })

  function openTaskWindow() {
    const r = router.resolve({
      name: 'TaskWindow',
      params: {
        id: props.task.project.id,
        taskId: props.task.id,
      }
    })
    window.open(r.href);
  }

</script>

<style scoped>

</style>
