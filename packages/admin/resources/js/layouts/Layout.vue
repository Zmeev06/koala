<template>
  <div
    id="layout-block"
    class="relative h-screen flex overflow-hidden bg-[#F5F5F5]"
    style="
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
    "
  >
    <LayoutSidebarMobileNew />
    <div>
      <LayoutSidebar />
    </div>

    <div class="flex flex-col w-0 flex-1 overflow-hidden">
      <LayoutHeader />

      <main class="flex-1 relative overflow-y-auto px-3 py-3 ml-[40px] md:m-0">
        <GlobalAlerts />

        <RouterView />
      </main>
    </div>
  </div>

  <Modal />
  <FlashMessage />
</template>

<script setup>
import FlashMessage from "Component/FlashMessage.vue";
import GlobalAlerts from "Component/GlobalAlerts.vue";
import Modal from "Component/NewModal.vue";
import LayoutHeader from "./Header.vue";
import LayoutSidebar from "./Sidebar.vue";
import LayoutSidebarMobile from "./SidebarMobile.vue";
import LayoutSidebarMobileNew from "./SideBarMobileNew.vue";
</script>
