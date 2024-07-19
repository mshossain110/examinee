import { ref } from 'vue'
import { createGlobalState } from '@vueuse/core'

export const useSidebarState = createGlobalState(
  () => {
    let sideBarOpen = ref(true);
    let fullScreenSideBarOpen = ref(true);

    function toggleSidebar() {
        sideBarOpen.value = !sideBarOpen.value;
        if (!sideBarOpen.value) {
          fullScreenSideBarOpen.value = false;
        }
    }
    function toggleFullScreenSidebar() {
        fullScreenSideBarOpen.value = !fullScreenSideBarOpen.value;
        if (fullScreenSideBarOpen.value) {
          sideBarOpen.value = true;
        }

    }

    return { sideBarOpen, fullScreenSideBarOpen, toggleSidebar, toggleFullScreenSidebar }
  }
)