<template>
    <div @click="task.isContentFormDesc = true" class="h-full min-h-[300px] max-h-[520px]">
<!--        <h1 class="text-gray-800 font-semibold mt-4">Описание</h1>-->
        <article
            class="prose prose-sm text-sm break-all max-h-full h-full max-w-full overflow-y-auto"
            v-if="task.data.description"
            v-html="marked.parse(task.data.description || '', { breaks: true, renderer })"
        ></article>

        <p v-else class="flex items-center text-gray-500 text-sm mt-4 font-light">
            <MenuAlt2Icon class="h-4 w-4 mr-2"/>

            {{ __('Description') }}
        </p>
    </div>
</template>

<script setup>
import { marked } from 'marked'
import { useTaskStore } from 'Store/task'
import { MenuAlt2Icon } from '@heroicons/vue/outline'

const task = useTaskStore()

const renderer = new marked.Renderer()
const linkRenderer = renderer.link
renderer.link = (href, title, text) => {
    const html = linkRenderer.call(renderer, href, title, text);
    return html.replace(/^<a /, `<a onclick="event.stopPropagation()" target="_blank" rel="noreferrer noopener nofollow" `)
}
</script>


<style scoped>
    article :deep(.ql-align-center) {
        text-align: center;
    }

    article{
        border-radius: 10px;
        border-width: 1px;
        font-size: .875rem;
        line-height: 1.25rem;
        padding: 0.5rem;
        width: 100%;
        max-width: unset;
    }
    article p {
      margin-top: 5px;
      margin-bottom: 5px;
    }
</style>
