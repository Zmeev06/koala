<template>
  <div class="flex items-center justify-start w-max gap-1 bg-white px-5 py-2 rounded-[10px]">
    <p class="rounded-md cursor-pointer px-2 hover:bg-gray-300 "
       :class="link.active? 'text-white bg-gray-700' : ''"
       v-for="link in links"
       v-html="link.label"
       @click="$emit('onLink', link.url)">
    </p>
  </div>
</template>

<script setup>
  const props = defineProps({
    links: Object
  })
</script>

<style scoped>

</style>
