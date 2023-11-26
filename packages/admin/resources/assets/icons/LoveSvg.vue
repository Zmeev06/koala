<template>
  <svg
    width="16"
    height="16"
    viewBox="0 0 16 16"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M2.53736 4.13721C3.78703 2.88753 5.81316 2.88753 7.06284 4.13721L8.0001 5.07447L8.93736 4.13721C10.187 2.88753 12.2132 2.88753 13.4628 4.13721C14.7125 5.38689 14.7125 7.41302 13.4628 8.66269L8.0001 14.1254L2.53736 8.66269C1.28768 7.41302 1.28768 5.38689 2.53736 4.13721Z"
      :fill="props.color"
    />
  </svg>
</template>
<script setup>
const props = defineProps({
  color: String,
});
</script>
