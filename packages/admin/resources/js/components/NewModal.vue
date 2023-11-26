<template>
  <Transition name="modal">
    <div id="modal" class="fixed inset-0 bg-gray-800 bg-opacity-75 overflow-y-auto z-[250] flex items-center justify-center"
         v-if="modal.open"
        >
<!--      <div class="modal-content bg-white rounded-lg shadow-xl mx-auto" :class="[modal.$state.width]" @click.stop>-->
      <div class="modal-content bg-white rounded-lg shadow-xl w-full h-full max-w-[87%] lg:h-auto overflow-y-auto" @click.stop>
        <Component :is="modal.$state.component" :id="modal.$state.id"/>
      </div>
    </div>
  </Transition>
</template>

<script setup>
  import { useModalStore } from 'Store/modal'


  const modal = useModalStore(),
      maxWidth = modal.$state.width
</script>
