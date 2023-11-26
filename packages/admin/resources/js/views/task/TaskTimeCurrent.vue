<template>
  <section>
    <!--        <h2 class="text-gray-600 text-sm font-medium px-2">Время выполнения</h2>-->

    <div
          class="flex h-full items-center"
          :class="props.task ? 'justify-start' : 'justify-end'"
         data-cooltipz-dir="top">
      <v-loader v-show="stopedTime.length == 0" size="24" color="#5850ec"/>
      <span class="block leading-none "
            :class="props.task ? 'text-xs text-gray-800' : 'text-lg'">{{ stopedTime }}</span>
    </div>
  </section>
</template>

<script setup>
import {onMounted} from "vue";
import {useTaskStore} from 'Store/task';
import {useTimerStore} from 'Store/timer'
import {ref} from "vue";
import moment from 'moment';

const props = defineProps({
  task: Object
})

const task = useTaskStore();
const timer = useTimerStore();
const isSetTime = ref(true);

if(props.task){
  task.data = props.task
}

const stopedTime = ref('')

if(task.data.status_time != 1){
  getTime()
} else {
  let new_time = Math.floor(Date.now() / 1000) - Number(task.data.timer_start_at) + Number(task.data.time_replicated)
  onMounted(() => {
    setInterval(() => {
      getTime(++new_time)
    }, 1000)
  })
}

function getTime(timer) {

  const hours = (sec) => {
    return Math.floor(sec / 3600).toString().padStart(2, '0')
  }
  const mins = (sec) => {
    return Math.floor(sec / 60 % 60).toString().padStart(2, '0')
  }
  const secs = (sec) => {
    return (sec % 60).toString().padStart(2, '0')
  }

  if (timer) {
    stopedTime.value = `${hours(timer)}:${mins(timer)}:${secs(timer)}`

  } else {
    stopedTime.value = `${hours(task.data.time_replicated)}:${mins(task.data.time_replicated)}:${secs(task.data.time_replicated)}`
  }

  // if (task.data.status_time == 1) {
  //
  //   let timestamp = task.data.total_seconds + Math.floor(Date.now() / 1000) - task.data.time_replicated
  //   timer.setTimer(timestamp);
  //   isSetTime.value = false;
  //
  //   return `${timer.currentTaskTimer.h.toString().padStart(2, '0')}:${timer.currentTaskTimer.m.toString().padStart(2, '0')}:${timer.currentTaskTimer.s.toString().padStart(2, '0')}`
  // }
  //
  // if (!isSetTime){
  //   return `${timer.currentTaskTimer.h.toString().padStart(2, '0')}:${timer.currentTaskTimer.m.toString().padStart(2, '0')}:${timer.currentTaskTimer.s.toString().padStart(2, '0')}`
  // }else{
  //   let timestamp = task.data.total_seconds;
  //
  //   var hours = Math.floor(timestamp / 60 / 60);
  //   var minutes = Math.floor(timestamp / 60) - (hours * 60);
  //   var seconds = timestamp % 60;
  //
  //   return [
  //     hours.toString().padStart(2, '0'),
  //     minutes.toString().padStart(2, '0'),
  //     seconds.toString().padStart(2, '0')
  //   ].join(':');
  // }


}

</script>

