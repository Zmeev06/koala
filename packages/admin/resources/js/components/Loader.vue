<template>
  <svg class="animate-spin stroke-current" :class="color" viewBox="0 0 32 32" :width="size" :height="size">
    <circle cx="16" cy="16" fill="none" r="14" :stroke-width="thick" style="opacity: 0.2;"></circle>
    <circle cx="16" cy="16" fill="none" r="14" :stroke-width="thick" style="stroke-dasharray: 80; stroke-dashoffset: 60;"></circle>
  </svg>
</template>

<script>
  export default {
    props: {
      size: {
        type: String,
        default: '20'
      },
      color: {
        type: String,
        default: 'text-gray-600'
      },
      thick: {
        type: String,
        default: '4'
      },
    }
  }
</script>
