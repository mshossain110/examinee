<template>
  <!-- give the sidebar z-50 class so its higher than the navbar if you want to see the logo -->
  <!-- you will need to add a little "X" button next to the logo in order to close it though -->
  <div
    id="main-nav"
    class="fixed z-30 h-screen w-1/2 border-r bg-white dark:bg-slate-800 mdhrefp-0 md:left-0 md:w-1/3 lg:w-64 transition-all duration-200"
    :class="sideBarOpen ? '' : 'hidden'"
  >
    <div class="mb-8 flex h-20 w-full items-center border-b px-4">
      <div class="flex justify-center lg:w-0 lg:flex-1">
        <Link :href="route('home')">
          <svg
            viewBox="0 0 50 31"
            class="h-6 w-auto text-indigo-500 dark:text-indigo-300"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M25.517 0C18.712 0 14.46 3.382 12.758 10.146c2.552-3.382 5.529-4.65 8.931-3.805 1.941.482 3.329 1.882 4.864 3.432 2.502 2.524 5.398 5.445 11.722 5.445 6.804 0 11.057-3.382 12.758-10.145-2.551 3.382-5.528 4.65-8.93 3.804-1.942-.482-3.33-1.882-4.865-3.431C34.736 2.92 31.841 0 25.517 0zM12.758 15.218C5.954 15.218 1.701 18.6 0 25.364c2.552-3.382 5.529-4.65 8.93-3.805 1.942.482 3.33 1.882 4.865 3.432 2.502 2.524 5.397 5.445 11.722 5.445 6.804 0 11.057-3.381 12.758-10.145-2.552 3.382-5.529 4.65-8.931 3.805-1.941-.483-3.329-1.883-4.864-3.432-2.502-2.524-5.398-5.446-11.722-5.446z"
              fill="currentColor"
            ></path>
          </svg>
          <p class="sr-only text-3xl font-semibold text-blue-400">
            {{ appName }}
          </p>
        </Link>
      </div>
    </div>

    <div class="mb-4 px-4">
      <!-- <p class="mb-1 pl-4 text-sm font-semibold dark:text-gray-100">MAIN</p> -->

      <Link
        v-for="item in navigation"
        :key="item.name"
        v-if="authenticated && roles && (roles.admin || roles.superAdmin)"
        :href="item.href"
      >
        <div
          class="flex h-10 w-full items-center rounded-lg pl-4 text-blue-400"
          :class="
            item.current
              ? 'cursor-default bg-gray-200 text-blue-600 hover:bg-gray-200 dark:bg-gray-900 dark:text-blue-200 dark:hover:bg-gray-900'
              : 'cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700'
          "
        >
          <component :is="item.icon" class="mr-2 mb-1 h-6 w-6" />
          <span class="">{{ item.name }}</span>
        </div>
      </Link>  
    </div>

    



    
  </div>
</template>

<script lang="ts">
import { Link } from "@inertiajs/vue3";
import useAuth from '@/Composables/useAuth';
import { useSidebarState } from '@/Composables/useSidebarState'
import {
  UsersIcon,
  BuildingLibraryIcon,
  ShieldCheckIcon,
  ShieldExclamationIcon,
  CogIcon,
  ServerStackIcon,
} from '@heroicons/vue/24/outline';

export default {
  name: 'AdminSidebar',
  components: {
    UsersIcon,
    BuildingLibraryIcon,
    ShieldCheckIcon,
    ShieldExclamationIcon,
    ServerStackIcon,
    CogIcon,
    Link
  },
  props: {
    appName: { type: String, default: 'Workflow' },
  },
  setup() {
    const { user, roles, authenticated } = useAuth();
    const { sideBarOpen, fullScreenSideBarOpen } = useSidebarState()
    const navigation = [
        { name: "Admin", icon: BuildingLibraryIcon,  href: route('admin.dashboard'), current: route().current("admin.dashboard") },
        { name: "Users", icon: UsersIcon,  href: route('admin.users.index'), current: route().current("admin.users.index") },
        { name: "Roles", icon: ShieldCheckIcon, href: route('admin.roles.index'), current: route().current("admin.roles.index") },
        { name: "Permissions", icon: ShieldExclamationIcon, href: "#", current: false },
        { name: "Server Info", icon: ServerStackIcon, href: route('admin.server-info'), current: route().current('admin.server-info') },
        { name: "App Settings", icon: CogIcon, href: "#", current: false },
    ];
    return {
      user,
      roles,
      authenticated,
      navigation,
      sideBarOpen,
      fullScreenSideBarOpen
    };
  },
  data() {
    return {
      isActive: true
    };
  },
  computed: {
    

  },
  watch: {},
  created() {},
  mounted() {},
  beforeUnmount() {},
  updated() {},
  methods: {
  },
};
</script>

<style scoped></style>
<style lang="scss" scoped></style>
