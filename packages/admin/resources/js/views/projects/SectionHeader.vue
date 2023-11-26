<template>
  <div class="flex items-center justify-between py-2.5 px-2 mb-2 rounded"
      :style="`background-color: ${hColor || props.headerColor}`">
    <div v-if="show" class="flex-1 ltr:pr-2 rtl:pl-2">
      <input ref="input" type="text" id="list-edit-input" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm text-sm border-gray-300 rounded-md" v-model="listName" @keyup.enter="submit">
    </div>

    <div class="px-2 font-semibold text-sm text-gray-700 leading-none" v-text="text" v-if="!show"></div>

      <div class="flex items-center gap-3">
<!--        @click="createTask()"-->
          <div v-if="!can('guest:view') || name == 'БЭКЛОГ'"  class="cursor-pointer hover:brightness-125 transition duration-75">
              <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <line x1="7.94531" y1="1" x2="7.94531" y2="13" stroke="#130032" stroke-width="2" stroke-linecap="round"/>
                  <line x1="1.94531" y1="7" x2="13.9453" y2="7" stroke="#130032" stroke-width="2" stroke-linecap="round"/>
              </svg>
          </div>
          <div v-if="!can('guest:view')" class="relative cursor-pointer hover:brightness-125 transition duration-75">
            <div @click="onColorPickerOpen($event)">
              <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <mask id="mask0_409_4158" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="15" height="14">
                  <rect x="0.21875" width="13.9444" height="14" fill="url(#pattern0)"/>
                </mask>
                <g mask="url(#mask0_409_4158)">
                  <rect x="-7.98389" y="-8.23535" width="30.3497" height="29.6471" fill="#130032"/>
                </g>
                <defs>
                  <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                    <use xlink:href="#image0_409_4158" transform="matrix(0.00196091 0 0 0.00195312 -0.00199202 0)"/>
                  </pattern>
                  <image id="image0_409_4158" width="512" height="512" xlink:href="data:image/png;base64,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"/>
                </defs>
              </svg>
            </div>

            <div v-if="colorPickerOpen">
              <Teleport to="#layout-block">
                  <color-picker @pick-color="(color) => onPickColor(color)" :coords="colorPickerCoords"/>
              </Teleport>
            </div>
          </div>
          <div  class="flex items-center cursor-pointer hover:brightness-125 transition duration-75" v-if="(can('task-list:update') || can('task-list:delete')) && !can('guest:view')">
              <SectionDropdown :list-id="id" :list-index="index" @list-edit="onListEdit"/>
          </div>
      </div>

  </div>
</template>

<script setup>
  import { ref } from 'vue'
  import SectionDropdown from './SectionDropdown.vue'
  import ColorPicker from "../settings/ColorPicker.vue";
  import {useRouter} from "vue-router";
  const router = useRouter()

  const props = defineProps({
    id: Number,
    index: Number,
    name: String,
    headerColor: String
  })


  const show = ref(false)
  const listName = ref('')
  const input = ref(null)
  const text = ref(props.name)
  const colorPickerOpen = ref(false)
  const colorPickerCoords = ref({})
  const hColor = ref(null)

  function closeIfClickedOutside(event) {
    console.log('closeIfClickedOutside')
    console.log(event.target.closest('#list-edit-input'))
    if (! event.target.closest('#list-edit-input')) {
      show.value = false
      document.removeEventListener('click', closeIfClickedOutside)
    }
  }


  function createTask() {
    const r = router.resolve({
      name: 'CreateTaskWindow',
    })
    window.open(r.href);
  }

  function onColorPickerOpen(e){
    colorPickerCoords.value = {
     x: e.x,
     y: e.y
    }
    colorPickerOpen.value = !colorPickerOpen.value;
  }

  function onListEdit() {
    show.value = true
    listName.value = text.value
  }

  function onPickColor(color) {
    hColor.value = color
    submit()
  }

  function submit() {


    axios.patch(`lists/${props.id}`, {
      name: listName.value || props.name,
      color: hColor.value
    })
      .then(data => {
        text.value = listName.value || props.name
        show.value = false
        listName.value = ''
        document.removeEventListener('click', closeIfClickedOutside)
      })
  }
</script>
