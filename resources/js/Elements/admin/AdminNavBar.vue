<template>
  <div class="sticky top-0 z-40">
    <div
      class="flex h-20 w-full items-center justify-between border-b bg-white px-6 dark:bg-slate-800"
    >
      <div class="flex">
        <div class="mr-4 inline-block flex items-center lg:hidden">
          <button
            class="navbar-burger rounded text-gray-600 hover:border-white hover:text-gray-500 focus:outline-none dark:bg-slate-800 dark:hover:bg-slate-800"
            :class="
              sideBarOpen ? 'bg-slate-100 text-gray-900 dark:text-gray-100' : ''
            "
            @click.prevent="toggleSidebar()"
          >
            <span v-if="!sideBarOpen" class="sr-only">Open menu</span>
            <span v-if="sideBarOpen" class="sr-only">CLose menu</span>
            <Bars3Icon v-if="!sideBarOpen" class="h-6 w-6" aria-hidden="true" />
            <XMarkIcon v-if="sideBarOpen" class="h-6 w-6" aria-hidden="true" />
          </button>
        </div>

        

        <div class="hidden lg:inline-flex">
          <div class="mr-4 inline-block flex items-center">
            <button
              class="navbar-burger rounded text-gray-600 hover:border-white hover:text-gray-500 focus:outline-none dark:bg-slate-800 dark:hover:bg-slate-800"
              @click="toggleFullScreenSidebar()"
            >
              <span v-if="!fullScreenSideBarOpen" class="sr-only"
                >Open menu</span
              >
              <span v-if="fullScreenSideBarOpen" class="sr-only"
                >CLose menu</span
              >
              <Bars3Icon
                v-if="!fullScreenSideBarOpen"
                class="h-6 w-6"
                aria-hidden="true"
              />
              <Bars3BottomLeftIcon
                v-if="fullScreenSideBarOpen"
                class="h-6 w-6"
                aria-hidden="true"
              />
            </button>
          </div>
        </div>
      </div>

      <div class="relative flex items-center">
        <div class="my-1 mr-3 mt-2 w-full py-2 sm:flex sm:items-center">
          <span
            v-tippy="'Toggle Theme ' + (isDark ? 'Light' : 'Dark')"
            @click="toggleDark()"
          >
            <Switch
              :class="isDark ? 'bg-gray-500' : 'bg-gray-400'"
              class="relative inline-flex h-[26px] w-[48px] shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
            >
              <span class="sr-only">Toggle Theme</span>
              <span
                aria-hidden="true"
                :class="
                  isDark
                    ? 'translate-x-5 bg-gray-800'
                    : 'translate-x-0 bg-white'
                "
                class="pointer-events-none inline-block h-[22px] w-[24px] transform rounded-full shadow-lg ring-0 transition duration-200 ease-in-out"
              />
            </Switch>
          </span>
        </div>

        <!--<img
          v-if="user && user.avatar"
          :src="user.avatar"
          :alt="user.name"
          class="h-8 w-8 cursor-pointer rounded-full border shadow-lg"
          @click="dropDownOpen = !dropDownOpen"
        /> -->
        <UserCircleIcon
          class="float-right ml-1 mt-0 h-16 w-16 cursor-pointer"
          @click="dropDownOpen = !dropDownOpen"
        />
      </div>
    </div>

    <div ref="dropMenu" class="relative mt-1">
      <div
        v-show="dropDownOpen"
        class="absolute right-5 z-10 flex w-auto flex-col whitespace-nowrap rounded border bg-white shadow-md dark:bg-slate-900"
        @click="dropDownOpen = !dropDownOpen"
      >
        <Link
            :href="route('logout')"
            method="post"
            as="button"
            class="flex cursor-pointer items-center rounded-b p-4 pr-10 pl-8 text-gray-700 hover:bg-slate-800 hover:text-white"
        >
          <ArrowLeftEndOnRectangleIcon
            class="mr-2 h-6 w-6"
          ></ArrowLeftEndOnRectangleIcon>
            Log Out
        </Link>

      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Link } from "@inertiajs/vue3";
import {
  Bars3Icon,
  HomeIcon,
  BuildingLibraryIcon,
  InformationCircleIcon,
  XMarkIcon,
  CogIcon,
  ArrowLeftEndOnRectangleIcon,
  Bars3BottomLeftIcon,
  UserCircleIcon,
} from '@heroicons/vue/24/outline';
import { Switch, Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import useAuth from '@/Services/useAuth';
import { useDark, useToggle } from '@vueuse/core'
import { useSidebarState } from '@/Services/useSidebarState'

export default {
  name: 'AdminNavBar',
  components: {
    HomeIcon,
    BuildingLibraryIcon,
    InformationCircleIcon,
    Bars3Icon,
    XMarkIcon,
    CogIcon,
    Link,
    ArrowLeftEndOnRectangleIcon,
    UserCircleIcon,
    Bars3BottomLeftIcon,
    Switch,
    Menu,
    MenuButton,
    MenuItems,
    MenuItem
  },
  props: {},
  setup() {
    const { user, roles, authenticated } = useAuth();
    const isDark = useDark()
    const toggleDark = useToggle(isDark)
    const { sideBarOpen, toggleSidebar, fullScreenSideBarOpen, toggleFullScreenSidebar  } = useSidebarState()

    return {
      user,
      roles,
      authenticated,
      isDark,
      toggleDark,
      sideBarOpen,
      toggleSidebar,
      fullScreenSideBarOpen,
      toggleFullScreenSidebar
    };
  },
  data() {
    return {
      dropDownOpen: false,
    };
  },
  computed: {

  },
  watch: {},
  created() {},

  beforeUnmount() {},
  updated() {},
  methods: {

    closeDrop() {
      this.dropDownOpen = false;
    },
    openDrop() {
      this.dropDownOpen = true;
    }
  },
};
</script>