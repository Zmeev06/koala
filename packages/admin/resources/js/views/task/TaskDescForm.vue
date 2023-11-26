<template>
  <section
    class="h-full flex flex-col gap-4"
    :class="{ 'opacity-50': processing }"
  >
    <h1 class="text-gray-800 font-semibold mt-4" v-if="can('guest:view')">
      {{ title }}
    </h1>
    <div class="border rounded-md overflow-hidden h-11" v-else>
      <input
        type="text"
        class="task-title block w-full text-md border-0 focus:ring-0 resize-none h-8 font-semibold text-base text-gray-800 placeholder:text-gray-500 placeholder:font-normal placeholder:text-sm px-2 py-2"
        placeholder="Task"
        v-model="title"
        @keydown.enter.prevent="save"
        @keydown.esc="cancel"
      />
    </div>
    <div v-html="description" v-if="can('guest:view')"></div>

    <div v-else class="border rounded-md overflow-hidden h-full">
      <quill-editor
        class="qleditor min-h-[250px]"
        :theme="'snow'"
        :toolbar="'essential'"
        v-model:content="description"
        :content="'html'"
        :contentType="'html'"
      />
    </div>

    <div
      class="flex items-center gap-2"
      v-if="!can('guest:view') || !task.data.id"
    >
      <button
        type="button"
        class="inline-flex bg-[#130032] items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-[10px] text-white hover:brightness-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        @click="save"
      >
        {{ __("Save") }}
      </button>
      <v-loader v-if="processing" :size="24" :color="'#3B2560'"></v-loader>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from "vue";
import autosize from "autosize";
import { useTaskStore } from "Store/task";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

onMounted(() => {
  // document.querySelector('.task-title').focus()
  autosize(document.querySelectorAll(".autosize"));
});

const task = useTaskStore(),
  processing = ref(false),
  title = ref(task.data.title),
  description = ref(task.data.description);

function save(e) {
  if (processing.value) return;

  if (
    task.data.title == title.value &&
    task.data.description == description.value
  ) {
    // cancel()
    return;
  }

  processing.value = true;

  axios
    .patch(`tasks/${task.data.id}`, {
      title: title.value,
      description: description.value,
    })
    .then((data) => {
      processing.value = false;
      task.data.title = title.value;
      task.data.description = description.value;
      // cancel()
    });
}

// function cancel() {
//     title.value = ''
//     description.value = ''
//     task.isContentFormDesc = false
// }
</script>

<style>
article {
  border-radius: 0.375rem;
  border-width: 1px;
  font-size: 0.875rem;
  line-height: 1.25rem;
  padding: 0.5rem;
  width: 100%;
  max-width: unset;
}
</style>
