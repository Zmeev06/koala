<script setup>
import TaskList from "./TaskList.vue";
import PageList from "./pagination/PageList.vue";
import Filter from "./Filter.vue";
import Statistic from "./Statistic.vue";
import { useReportsStore } from "../../stores/reports";
import { ref } from "vue";
import { fetchGetTasks } from "../../api/reportsApi.js";
import axios from "axios";

const data = ref(null),
  url = ref("/api/reports/get-tasks"),
  store = useReportsStore(),
  isFiltered = ref(false),
  dataStat = ref(null);

function paginateTo(link) {
  if (link) {
    url.value = link;
    loadData();
  }
}

function onFilter() {
  isFiltered.value = true;
  loadData();
}

function loadData() {
  axios({
    method: "get",
    url: url.value,
    params: store.filters,
  }).then((res) => {
    data.value = res.data.data;
  });

  axios({
    method: "get",
    url: "/api/reports/get-tasks-stat",
    params: store.filters,
  }).then((res) => {
    dataStat.value = res.data;
  });
}

loadData();
</script>

<template>
  <div class="flex flex-col gap-4">
    <h1 class="text-2xl font-semibold text-[#424242]">Отчеты</h1>
    <div class="">
      <Filter @on-filter="onFilter()" />
    </div>
    <div class="grid gap-4 grid-cols-[40%_1fr]">
      <div
        v-if="data && data.data.length > 0"
        class="flex rounded-[10px] overflow-hidden bg-white p-4"
      >
        <task-list :tasks="data.data" />
      </div>
      <div
        v-if="dataStat && data.data.length > 0"
        class="flex flex-col flex rounded-[10px] overflow-hidden w-full h-full bg-white p-4"
      >
        <statistic :data="dataStat"></statistic>
      </div>
    </div>
    <div class="">
      <page-list
        v-if="data && data.data.length > 0"
        @on-link="(url) => paginateTo(url)"
        :links="data.links"
      />
    </div>
  </div>
</template>

<style scoped></style>
