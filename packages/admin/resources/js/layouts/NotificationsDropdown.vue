<template>
  <v-dropdown name="header-notification" @toggle="onOpen">
    <template #trigger>
      <button
        class="relative p-1 text-white hover:text-gray-200 focus:outline-none"
        aria-label="Notifications"
      >
        <svg
          width="20"
          height="20"
          viewBox="0 0 20 20"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M17.1892 13.3324C17.1244 13.2543 17.0607 13.1762 16.9982 13.1008C16.1388 12.0613 15.6189 11.434 15.6189 8.49141C15.6189 6.96797 15.2545 5.71797 14.5361 4.78047C14.0064 4.08789 13.2904 3.5625 12.3467 3.17422C12.3345 3.16746 12.3237 3.1586 12.3146 3.14805C11.9752 2.01133 11.0463 1.25 9.99861 1.25C8.95095 1.25 8.02244 2.01133 7.68299 3.14687C7.67393 3.15704 7.66323 3.16562 7.65135 3.17227C5.449 4.07891 4.37869 5.81836 4.37869 8.49023C4.37869 11.434 3.85955 12.0613 2.99939 13.0996C2.93689 13.175 2.87322 13.2516 2.80838 13.3313C2.64088 13.5333 2.53475 13.779 2.50256 14.0394C2.47037 14.2999 2.51346 14.5641 2.62674 14.8008C2.86775 15.3086 3.38142 15.6238 3.96775 15.6238H16.0338C16.6174 15.6238 17.1275 15.309 17.3693 14.8035C17.4831 14.5668 17.5266 14.3023 17.4947 14.0416C17.4627 13.7809 17.3567 13.5348 17.1892 13.3324Z"
            fill="#21272A"
          />
          <path
            d="M9.99977 18.75C10.5642 18.7495 11.1181 18.5963 11.6025 18.3066C12.0869 18.0168 12.4839 17.6014 12.7513 17.1043C12.7639 17.0805 12.7702 17.0538 12.7694 17.0269C12.7686 16.9999 12.7609 16.9736 12.747 16.9506C12.7331 16.9275 12.7134 16.9084 12.69 16.8952C12.6665 16.8819 12.64 16.875 12.613 16.875H7.38727C7.36029 16.8749 7.33374 16.8818 7.31021 16.895C7.28669 16.9082 7.26698 16.9273 7.25302 16.9504C7.23905 16.9735 7.23131 16.9998 7.23053 17.0268C7.22976 17.0537 7.23598 17.0804 7.2486 17.1043C7.51599 17.6013 7.91291 18.0167 8.39727 18.3065C8.88163 18.5962 9.43537 18.7495 9.99977 18.75Z"
            fill="#21272A"
          />
        </svg>

        <div
          class="flex items-center justify-center w-[1.125rem] h-[1.125rem] rounded-full bg-red-600 text-white text-[0.65rem] absolute z-40 -top-0.5 ltr:-right-0.5 rtl:-left-0.5"
          v-if="count"
        >
          {{ count > 9 ? "9+" : count }}
        </div>
      </button>
    </template>

    <div
      class="origin-top-right absolute ltr:right-0 rtl:left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden"
      role="menu"
      aria-orientation="vertical"
      aria-labelledby="user-menu"
    >
      <p
        class="py-4 text-center text-sm text-gray-700"
        v-if="!notifications.length"
      >
        {{ __("No Notifications!") }}
      </p>

      <div v-else>
        <router-link
          custom
          :to="getUrl(notification)"
          v-slot="{ href, navigate }"
          v-for="notification in notifications"
          :key="notification.id"
        >
          <a
            :href="href"
            @click="navigate"
            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150"
            role="menuitem"
          >
            {{ notification.data.message }}
          </a>
        </router-link>
      </div>
    </div>
  </v-dropdown>
</template>

<script setup>
import { ref } from "vue";
import VDropdown from "Component/Dropdown.vue";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

let notifications = ref([]),
  count = ref();

const E = new Echo({
  broadcaster: "pusher",
  key: Config.PUSHER_APP_KEY,
  cluster: Config.PUSHER_APP_CLUSTER,
  forceTLS: true,
});

E.private(`App.Models.User.${Config.user.id}`).notification((notification) => {
  console.log("notification");
  console.log(notification);
  count.value = count.value + 1;
  notifications.value.push({
    type: notification.type,
    data: {
      item_id: notification.item_id,
      project_id: notification.project_id,
      message: notification.message,
    },
  });
});

axios.get("notifications").then((data) => {
  console.log(data);
  count.value = data.new;
  notifications.value = data.notifications;
});

function onOpen(payload) {
  if (payload && count.value) {
    axios.post("/notifications/read").then((data) => {
      if (data.success) count.value = 0;
    });
  }
}

function getUrl(notification) {
  const types = {
    "App\\Notifications\\ProjectAssigned":
      "/projects/" + notification.data.item_id,
    "App\\Notifications\\TaskAssigned":
      "/projects/" + notification.data.project_id,
  };

  return types[notification.type];
}
</script>
