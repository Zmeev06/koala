<template>
  <div class="relative group flex py-1">
    <div class="w-6 h-6">
      <UserAvatar class="w-6 h-6" :user="comment.user" />
    </div>
    <div class="flex-1 ltr:pl-4 rtl:pr-4 group">
      <div class="flex">
        <h2 class="flex leading-none font-medium text-sm text-gray-700">
          {{ comment.user.name }}
        </h2>
      </div>

      <p class="mt-1.5 prose text-xs text-black break-all" v-html="marked.parse(comment.text || '', { breaks: true, renderer })"></p>


      <div class="flex items-center justify-start flex-wrap gap-2 mt-1.5" v-if="comment.attachments.length">
        <div v-for="attachment in comment.attachments">
<!--          <div class="flex items-center flex-1">-->
<!--            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">-->
<!--              <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />-->
<!--            </svg>-->
<!--            <a :href="'/' + attachment.path" class="block ltr:ml-2 rtl:mr-2 flex-1 w-0 truncate text-xs text-gray-700 hover:underline ltr:pr-2 rtl:pl-2" target="blank">-->
<!--              {{ attachment.name }}-->
<!--            </a>-->
<!--          </div>-->
<!--          <a :href="'/' + attachment.path" class="ltr:ml-auto rtl:mr-auto" target="blank">-->
<!--            <DownloadIcon class="h-5 w-5 text-gray-400"/>-->
<!--          </a>-->
          <a :href="'/' + attachment.path" target="blank" class="block w-[56px] h-[56px] rounded-[5px] overflow-hidden hover:brightness-90">
            <img v-if="attachment.path.match(/(?:jpg|jpeg|png|webp|gif|svg|avif)$/)"
               :src="'/' + attachment.path"
               class="w-full h-full object-cover"
               alt="">
            <span v-else class="w-[56px] h-[56px] rounded-[5px] border border-gray-300 flex items-center justify-center">
              <svg  class="w-5 р-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <path d="M320 464c8.8 0 16-7.2 16-16V160H256c-17.7 0-32-14.3-32-32V48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320zM0 64C0 28.7 28.7 0 64 0H229.5c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64z"/>
              </svg>
            </span>

          </a>
        </div>
      </div>
      <p class="mt-1.5 font-normal text-gray-500 text-xs">{{ comment.updated_at }}</p>
    </div>


    <div class="absolute flex items-center right-0 bg-white pl-4" :class="{ 'opacity-50': processing }" v-if="deleteConfirmation">
      <span class="text-gray-600 text-sm mr-2">{{ __('Are you sure to delete?') }}</span>
      <CheckCircleIcon class="w-5 h-5 text-green-600 cursor-pointer hover:text-green-800 mr-1" @click="deleteComment"/>
      <XCircleIcon class="w-5 h-5 text-red-600 cursor-pointer hover:text-red-800" @click="deleteConfirmation = false"/>
    </div>

    <div class="absolute hidden group-hover:flex right-0 bg-white pl-4" v-else>
      <!-- <span @click="task.commentForm = index" class="mr-1">
        <PencilAltIcon class="w-4 h-4 text-gray-500 cursor-pointer hover:text-gray-900"/>
      </span> -->
      <TrashIcon class="w-4 h-4 text-gray-500 cursor-pointer hover:text-gray-900" @click="deleteConfirmation = true"/>
    </div>





    <!-- <div class="w-4" v-if="config.user.id == comment.author_id">
      <span @click="onDelete(comment.id, index)">
        <TrashIcon class="w-4 h-4 text-gray-500 hover:text-gray-800 cursor-pointer"/>
      </span>
    </div> -->
  </div>
</template>

<script setup>
  import { ref } from 'vue'
  import { marked } from 'marked'
  import { useTaskStore } from 'Store/task'
  import UserAvatar from 'Component/UserAvatar.vue'
  import { PencilAltIcon, TrashIcon, XCircleIcon, CheckCircleIcon, DownloadIcon } from '@heroicons/vue/outline'

  const props = defineProps({
    id: Number,
    index: Number,
    comment: Object,
  })

  const renderer = new marked.Renderer()
  const linkRenderer = renderer.link
  renderer.link = (href, title, text) => {
    const html = linkRenderer.call(renderer, href, title, text);
    return html.replace(/^<a /, `<a target="_blank" rel="noreferrer noopener nofollow" `)
  }

  const task = useTaskStore(),
    deleteConfirmation = ref(false),
    processing = ref(false),
    config = Config

  function deleteComment() {
    if (processing.value) return

    processing.value = true

    axios.delete(`comments/${props.id}`)
      .then(data => {
        processing.value = false
        if (!data.success) return
        task.data.comments.splice(props.index, 1)
      })
  }
</script>
