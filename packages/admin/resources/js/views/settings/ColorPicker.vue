<template>
    <div class="bg-white p-6 shadow-small rounded-md grid grid-cols-7 gap-1 fixed z-40"
         :style="`top: ${props.coords.y+20}px; left: ${props.coords.x-30}px`">
      <div class="w-[24px] h-[24px] rounded-sm cursor-pointer hover:ring-1 ring-gray-300"
           v-for = "color in colors"
           @click = "$emit('pickColor', color)"
           :style = "`background-color: ${color}`"
        >
      </div>
    </div>
</template>

<script setup>
  const props = defineProps({
    coords: Object
  });
  const colors = [
    '#F7D3D3', '#FFDAC1', '#FFFCBC', '#D0F4D5', '#C5FAFF', '#9DBEDF', '#C4BAED',
    '#F37D7D', '#F7AA78', '#FFF97E', '#79D587', '#7BD9FF', '#6094D5', '#A284BF'
  ];
</script>

<style scoped>

</style>
