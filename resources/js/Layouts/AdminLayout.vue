<template>
  <div id="main-body" class="leading-normal tracking-normal">
    <div class="flex flex-wrap">
      <AdminSidebar :class="fullScreenSideBarOpen ? '' : 'lg:hidden'" />
      <div
        id="main-content"
        class="min-h-screen w-full bg-white pl-0 dark:bg-slate-800 transition-all duration-200"
        :class="
          (sideBarOpen ? 'overlay ' : ' ') +
          (fullScreenSideBarOpen ? 'lg:pl-64' : '')
        "
      >
        <AdminNavBar />
        <div class="mb-20 bg-white dark:bg-slate-800">
          <slot />
        </div>
        <AdminFooter
          class="sticky top-[100vh] w-full"
          footer-class="border-slate-900/5 dark:border-slate-700"
          border-class=""
        />
      </div>
    </div>
  </div>
</template>

<script>
import AdminNavBar from '@/Elements/admin/AdminNavBar.vue';
import AdminSidebar from '@/Elements/admin/AdminSidebar.vue';
import AdminFooter from '@/Elements/admin/AdminFooter.vue';
import { useSidebarState } from '@/Services/useSidebarState'

export default {
  name: 'AdminLayout',
  components: {
    AdminNavBar,
    AdminSidebar,
    AdminFooter,
  },
  props: {},
  setup() {
    const { sideBarOpen, fullScreenSideBarOpen } = useSidebarState()
    return {sideBarOpen, fullScreenSideBarOpen}
  },
  data() {
    return {
      //
    };
  },
  computed: {
  },
  watch: {},
  created() {},
  mounted() {},
  beforeUnmount() {},
  updated() {},
  methods: {},
};
</script>

<style scoped></style>
<style lang="scss" scoped></style>
