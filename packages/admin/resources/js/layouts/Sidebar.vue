<template>
  <div
    class="bg-[#1d1b20] pt-[8px] px-[12px] h-screen transition-all duration-300 hidden md:block overflow-y-auto"
    :class="isOpen ? 'min-w-max  w-[14vw]' : 'w-[40px]'"
  >
    <div class="" :class="isOpen ? 'min-w-[40px] w-full' : 'w-[16vw]'">
      <div class="w-full flex gap-[15px] h-[30px] items-center">
        <div class="w-24px">
          <svg
            width="14"
            height="10"
            viewBox="0 0 14 10"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            class="cursor-pointer"
            @click="burgerToggle"
          >
            <path
              d="M1 1H13"
              stroke="#E0E0E0"
              stroke-width="1.666"
              stroke-miterlimit="16"
              stroke-linecap="square"
              stroke-linejoin="round"
            />
            <path
              d="M1 5H13"
              stroke="#E0E0E0"
              stroke-width="1.666"
              stroke-miterlimit="16"
              stroke-linecap="square"
              stroke-linejoin="round"
            />
            <path
              d="M1 9H13"
              stroke="#E0E0E0"
              stroke-width="1.666"
              stroke-miterlimit="16"
              stroke-linecap="square"
              stroke-linejoin="round"
            />
          </svg>
        </div>

        <div
          class="w-fit overflow-hidden transition-all"
          :class="isOpen ? 'opacity-1' : 'opacity-0'"
        >
          <svg
            width="80"
            height="28"
            viewBox="0 0 80 28"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M0 13.5699V22.2661H0.791964H1.58393L1.62353 20.8709C1.66313 20.1255 1.68292 18.8641 1.68292 18.1187C1.68292 17.3542 1.74232 16.7043 1.80172 16.6852C1.94031 16.6279 7.95924 21.8647 8.07804 22.1132C8.11763 22.2088 8.65221 22.2661 9.26598 22.2661H10.3747L9.78076 21.731C9.46397 21.4443 7.89984 20.0682 6.29612 18.6729C4.69239 17.2777 3.34605 16.0736 3.28665 15.9781C3.22725 15.8825 4.73199 14.5828 6.6327 13.0729L10.0777 10.3207L9.10759 10.2634L8.15723 10.206L5.04877 12.7098C3.34605 14.0668 1.88092 15.1944 1.80172 15.1944C1.72252 15.1944 1.64333 13.589 1.64333 11.6013C1.64333 9.63266 1.64333 7.32003 1.62353 6.44085L1.58393 4.87362H0.791964H0V13.5699Z"
              fill="white"
            />
            <path
              d="M39.9941 13.5699V22.2661H40.8851H41.7761V13.5699V4.87362H40.8851H39.9941V13.5699Z"
              fill="white"
            />
            <path
              d="M29.3427 10.0723C27.4024 10.2634 26.1352 10.7985 26.1352 11.4484C26.1352 12.1364 26.3332 12.1746 27.6399 11.7351C29.0457 11.2381 31.481 11.1617 32.3719 11.5821C33.0847 11.9071 33.6589 12.9391 33.6589 13.8757V14.5637L31.6394 14.6784C29.3625 14.7931 28.3131 15.0989 27.046 15.9589C24.4325 17.7746 24.9869 21.5016 27.9963 22.2852C29.6594 22.7248 31.8572 22.1132 33.0649 20.8518C33.7381 20.1637 33.7579 20.1637 33.8965 20.5842C33.9559 20.8327 34.0153 21.3105 34.0351 21.6354C34.0549 22.247 34.0944 22.2661 34.8666 22.2661H35.6982L35.5398 21.4443C35.4606 21.0047 35.3418 18.7494 35.2626 16.4176L35.1438 12.1938L34.5894 11.4866C33.5797 10.2252 32.0353 9.80467 29.3427 10.0723ZM33.6589 17.0101C33.6589 18.52 33.2233 19.4757 32.1343 20.3357C31.481 20.8709 30.3326 21.234 29.5605 21.1767C29.4219 21.1767 29.0853 21.1576 28.8081 21.1385C28.5309 21.1385 28.0359 20.8709 27.6993 20.5842C27.1648 20.1255 27.0856 19.9153 27.0658 19.0552C27.0262 16.991 28.9071 15.8634 32.5303 15.7869L33.6589 15.7678V17.0101Z"
              fill="white"
            />
            <path
              d="M15.4235 10.2062C14.0772 10.6267 12.7507 11.869 12.0181 13.4171C11.6617 14.1625 11.5825 14.6785 11.5825 16.2458C11.5825 17.985 11.6419 18.2717 12.1567 19.2465C13.2258 21.2915 14.691 22.2471 17.0075 22.4C19.4032 22.5721 21.5217 21.3871 22.5908 19.2847C23.0066 18.4628 23.066 18.0806 23.066 16.1502C23.066 14.2581 23.0066 13.8376 22.6304 13.1686C21.9771 12.0028 21.2445 11.2383 20.2347 10.6649C19.4824 10.2253 19.0666 10.1488 17.641 10.0915C16.7105 10.0724 15.7007 10.1106 15.4235 10.2062ZM19.3438 11.697C21.3039 12.5761 22.175 16.3604 21.0069 18.9215C19.6804 21.8075 15.2652 21.9031 13.8396 19.0936C13.305 18.0041 13.1071 15.5386 13.4436 14.3154C13.701 13.3789 14.3544 12.4041 15.087 11.8881C16.0967 11.1618 17.9776 11.0854 19.3438 11.697Z"
              fill="white"
            />
            <path
              d="M48.31 10.3016C46.9637 10.6648 46.5281 10.9515 46.5281 11.4675C46.5281 12.1556 46.8251 12.2129 48.0724 11.7351C49.3792 11.2573 52.0521 11.1426 52.8242 11.544C53.5172 11.9071 54.0518 12.8819 54.0518 13.7993V14.6211H52.8044C49.4188 14.6211 46.9439 15.6914 46.1519 17.5071C45.6371 18.6348 45.6371 19.4566 46.1123 20.4696C46.8053 21.9221 48.1912 22.5911 50.1513 22.3808C51.5373 22.247 53.0222 21.5208 53.6756 20.6798L54.131 20.0682L54.2696 20.546C54.3488 20.8136 54.4082 21.3105 54.428 21.6354C54.4478 22.247 54.4873 22.2662 55.2595 22.2662C56.0713 22.2662 56.0713 22.2662 55.9723 21.6354C55.8931 21.3105 55.7941 19.3419 55.7347 17.2969C55.5763 12.2129 55.5565 12.0791 54.6853 11.1999C54.2498 10.7603 53.636 10.3781 53.1608 10.2443C52.1313 9.97673 49.4386 9.99584 48.31 10.3016ZM54.0518 17.0102C54.0518 19.1126 52.8242 20.6989 50.8839 21.1003C48.607 21.5781 47.1419 20.4122 47.5379 18.3863C47.8348 16.7617 49.7158 15.8443 52.8242 15.787L54.0518 15.7679V17.0102Z"
              fill="white"
            />
            <path
              d="M63.6146 0.420604C63.1988 0.821969 63.1592 1.05132 63.1592 2.58033V4.31958L63.6542 3.86088C64.1293 3.4404 64.1689 3.32572 64.1095 1.70115L64.0501 0.000125885L63.6146 0.420604Z"
              fill="#31B492"
            />
            <path
              d="M69.7719 4.2812C65.9902 5.98222 65.1785 10.3208 68.1087 13.0539C71.8508 16.5324 78.1865 12.9774 77.0381 8.04639C76.7609 6.80407 75.6324 5.35151 74.3851 4.60611C73.1377 3.86072 71.0192 3.70782 69.7719 4.2812ZM72.6031 9.04025C73.1773 9.40339 73.4941 11.544 73.0585 12.3276C72.6031 13.1495 70.8608 12.9201 70.544 11.9836C70.2668 11.1617 70.544 9.46072 70.9796 9.15492C71.3756 8.86823 72.227 8.81089 72.6031 9.04025Z"
              fill="#31B492"
            />
            <path
              d="M71.5144 9.88115C71.3759 10.0149 71.2769 10.531 71.2769 11.0279C71.2769 11.9262 71.2967 11.9453 71.8708 11.9453C72.4054 11.9453 72.4648 11.888 72.445 11.3146C72.4054 9.99582 72.0094 9.40333 71.5144 9.88115Z"
              fill="#31B492"
            />
            <path
              d="M63.9509 4.70175C62.7828 5.88673 63.456 7.77888 65.1389 8.04646L65.8318 8.16113L65.1389 7.79799C62.9412 6.68946 64.2083 3.89901 66.505 4.7782L67.2178 5.06489L66.6634 4.58707C65.8318 3.8799 64.7231 3.91813 63.9509 4.70175Z"
              fill="#31B492"
            />
            <path
              d="M76.6818 4.58716L76.1274 5.06497L76.8798 4.77828C78.9785 3.95644 80.3051 6.59398 78.3647 7.74074C77.6124 8.18033 77.949 8.25678 78.8003 7.8363C80.1665 7.14825 80.404 5.81037 79.3151 4.75917C78.4637 3.93733 77.5134 3.87999 76.6818 4.58716Z"
              fill="#31B492"
            />
            <path
              d="M65.1786 5.67661C64.8024 6.03975 64.9014 6.74692 65.3568 6.97627C65.832 7.22473 65.7726 7.26296 66.228 6.422C66.5051 5.88685 66.5051 5.75306 66.2874 5.61927C65.9112 5.38992 65.4558 5.40903 65.1786 5.67661Z"
              fill="#31B492"
            />
            <path
              d="M77.0386 5.61911C76.7813 5.77201 76.8011 5.9058 77.1178 6.47918C77.3356 6.86143 77.5336 7.16724 77.5732 7.16724C77.9296 7.16724 78.4048 6.68942 78.4048 6.34539C78.4048 5.58089 77.7118 5.21775 77.0386 5.61911Z"
              fill="#31B492"
            />
            <path
              d="M63.1592 11.6588V15.3857H63.6542H64.1491V11.9837C64.1293 8.60076 64.1293 8.60076 63.6542 8.25673L63.1592 7.9127V11.6588Z"
              fill="#31B492"
            />
            <path
              d="M76.3652 13.1495C76.1078 13.4935 75.395 14.0287 74.8209 14.3345C73.4547 15.0416 71.059 15.2328 69.5147 14.7358C68.3069 14.3536 68.3069 14.3536 68.3069 14.7358C68.3069 14.8887 68.0496 15.2901 67.7328 15.5959C67.1586 16.1311 67.0992 16.1502 65.1589 16.1502H63.1592V16.8764C63.1592 18.1761 63.3968 18.2526 67.2972 18.2526C71.5144 18.2526 72.3658 17.985 73.4745 16.2457C73.8309 15.7106 73.8507 15.6915 73.8507 16.1119C73.8507 17.5645 72.0688 19.0171 70.2869 19.0171C69.1979 19.0171 69.2771 19.3993 70.4453 19.8962C71.5342 20.3549 72.0688 21.1768 72.0688 22.4L72.049 23.1263L71.5342 22.1133C70.9204 20.871 70.1483 20.3549 68.9009 20.3549C67.8318 20.3549 66.8814 20.871 66.327 21.7311C66.0103 22.228 65.9311 22.7058 65.9311 23.929C65.9311 26.0887 65.9311 26.0887 64.4263 26.0887H63.1592V26.815C63.1592 27.2164 63.2582 27.6369 63.3968 27.7706C63.5552 27.9235 64.6243 28 66.921 28C69.7127 28 70.4057 27.9427 71.3758 27.6177C73.7121 26.8341 75.4544 25.4007 76.385 23.4321C76.8998 22.3809 76.9196 22.2471 77.0186 17.4307C77.078 14.7358 77.0582 12.5188 76.9988 12.5188C76.9196 12.5188 76.6424 12.8055 76.3652 13.1495Z"
              fill="#31B492"
            />
            <path
              d="M63.1592 20.2403C63.1592 21.6546 63.179 21.6929 63.6542 21.6929C64.1293 21.6929 64.1491 21.6546 64.1491 20.355C64.1491 19.6096 64.0699 19.0171 63.9709 19.0171C63.872 19.0171 63.6542 18.9598 63.476 18.9024C63.1988 18.8069 63.1592 18.998 63.1592 20.2403Z"
              fill="#31B492"
            />
            <path
              d="M67.4752 19.3611C67.396 19.6478 67.4752 19.686 67.9306 19.6287C68.6235 19.5331 68.7027 19.0171 68.0296 19.0171C67.7524 19.0171 67.5148 19.1509 67.4752 19.3611Z"
              fill="#31B492"
            />
            <path
              d="M63.1592 23.7952C63.1592 25.0948 63.179 25.1331 63.6542 25.1331C64.1293 25.1331 64.1491 25.0948 64.1491 23.7952C64.1491 22.4955 64.1293 22.4573 63.6542 22.4573C63.179 22.4573 63.1592 22.4955 63.1592 23.7952Z"
              fill="#31B492"
            />
          </svg>
        </div>
      </div>
      <div class="flex flex-col gap-[8px] mt-[12px] h-[100vh]">
        <RouterLink
          :to="`/${item.link}`"
          custom
          v-slot="{ navigate, href, route }"
          v-for="(item, index) in sections"
          :key="index"
          @click="updateSection(item.id)"
        >
          <a
            :href="href"
            @click="navigate"
            class="flex items-center gap-3 cursor-pointer h-[20px]"
          >
            <div class="w-[16px] h-[16px]">
              <component
                :is="item.svg"
                class=""
                :color="currentRouteName === item.id ? '#31B492' : '#BEDCFD'"
              />
            </div>

            <div class="w-[80%] overflow-hidden">
              <p
                :class="`
             ${currentRouteName === item.id ? 'text-[#31B492]' : 'text-[#fff]'} 
              ${isOpen ? 'translate-x-0' : 'translate-x-[-100%]'}
            `"
                class="w-full text-sm duration-300 select-none"
              >
                {{ item.name }}
              </p>
            </div>
          </a>
        </RouterLink>

        <SidebarProjects :projects="projectsTest" :is-open-sidebar="isOpen" />

        
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from "vue";
import { useRouter } from "vue-router";
import HomeSvg from "../assets/icons/HomeSvg.vue";
import TasksSvg from "../assets/icons/TasksSvg.vue";
import Puzzle from "../assets/Puzzle.vue";
import UserGroup from "../assets/UserGroup.vue";
import ViewGrid from "../assets/ViewGrid.vue";
import SidebarProjects from "./SidebarProjects.vue";
import ChartBar from "../assets/ChartBar.vue";
import SidebarProjectsArchived from "./SidebarProjectsArchived.vue";
const router = useRouter();

const currentRouteName = computed(() => router.currentRoute.value.name);

const sections = [
  {
    id: undefined,
    name: "Главная",
    svg: HomeSvg,
    link: "/",
  },
  {
    id: "Tasks",
    name: "Мои задачи",
    svg: TasksSvg,
    link: "tasks",
  },
  {
    id: "Works",
    name: "В работе",
    svg: Puzzle,
    link: "works",
  },
  {
    id: "Users",
    name: "Пользователи",
    svg: UserGroup,
    link: "users",
  },
  {
    id: "Reports",
    name: "Отчеты",
    svg: ChartBar,
    link: "reports",
  },
];

const isOpen = ref(true);
const burgerToggle = () => {
  isOpen.value = !isOpen.value;
};
</script>
