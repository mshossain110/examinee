<template>
    <TransitionRoot :appear="appear" :show="isOpen" as="template" @after-leave="onAfterLeave">
      <HDialog :class="ui.wrapper" v-bind="attrs" @close="close">
        <TransitionChild v-if="overlay" as="template" :appear="appear" v-bind="ui.overlay.transition">
          <div :class="[ui.overlay.base, ui.overlay.background]" />
        </TransitionChild>
  
        <div :class="ui.inner">
          <div :class="[ui.container, !fullscreen && ui.padding]">
            <TransitionChild as="template" :appear="appear" v-bind="transitionClass">
              <HDialogPanel
                :class="[
                  ui.base,
                  ui.background,
                  ui.ring,
                  ui.shadow,
                  fullscreen ? ui.fullscreen : [ui.width, ui.height, ui.rounded, ui.margin],
                ]"
              >
                <slot />
              </HDialogPanel>
            </TransitionChild>
          </div>
        </div>
      </HDialog>
    </TransitionRoot>
  </template>
  
  <script lang="ts">
  import { computed, toRef, defineComponent } from 'vue'
  import type { PropType } from 'vue'
  import { Dialog as HDialog, DialogPanel as HDialogPanel, TransitionRoot, TransitionChild, provideUseId } from '@headlessui/vue'
  import { useUI } from '@/Services/useUI';
  import type { Strategy } from '@/types';


  
  const config = {
  wrapper: 'relative z-50',
  inner: 'fixed inset-0 overflow-y-auto',
  container: 'flex min-h-full items-end sm:items-center justify-center text-center',
  padding: 'p-4 sm:p-0',
  margin: 'sm:my-8',
  base: 'relative text-left rtl:text-right flex flex-col',
  overlay: {
    base: 'fixed inset-0 transition-opacity',
    background: 'bg-gray-200/75 dark:bg-gray-800/75',
    // Syntax for `<TransitionRoot>` component https://headlessui.com/vue/transition#basic-example
    transition: {
      enter: 'ease-out duration-300',
      enterFrom: 'opacity-0',
      enterTo: 'opacity-100',
      leave: 'ease-in duration-200',
      leaveFrom: 'opacity-100',
      leaveTo: 'opacity-0'
    }
  },
  background: 'bg-white dark:bg-gray-900',
  ring: '',
  rounded: 'rounded-lg',
  shadow: 'shadow-xl',
  width: 'w-full sm:max-w-lg',
  height: '',
  fullscreen: 'w-screen h-screen',
  // Syntax for `<TransitionRoot>` component https://headlessui.com/vue/transition#basic-example
  transition: {
    enter: 'ease-out duration-300',
    enterFrom: 'opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95',
    enterTo: 'opacity-100 translate-y-0 sm:scale-100',
    leave: 'ease-in duration-200',
    leaveFrom: 'opacity-100 translate-y-0 sm:scale-100',
    leaveTo: 'opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95'
  }
}
  
  export default defineComponent({
    components: {
      HDialog,
      HDialogPanel,
      TransitionRoot,
      TransitionChild
    },
    inheritAttrs: false,
    props: {
      modelValue: {
        type: Boolean,
        default: false
      },
      appear: {
        type: Boolean,
        default: false
      },
      overlay: {
        type: Boolean,
        default: true
      },
      transition: {
        type: Boolean,
        default: true
      },
      preventClose: {
        type: Boolean,
        default: false
      },
      fullscreen: {
        type: Boolean,
        default: false
      },
      class: {
        type: [String, Object, Array] as PropType<any>,
        default: () => ''
      },
      ui: {
        type: Object as PropType<Partial<typeof config> & { strategy?: Strategy }>,
        default: () => ({})
      }
    },
    emits: ['update:modelValue', 'close', 'close-prevented', 'after-leave'],
    setup (props, { emit }) {
      const { ui, attrs } = useUI('modal', toRef(props, 'ui'), config, toRef(props, 'class'))
  
      const isOpen = computed({
        get () {
          return props.modelValue
        },
        set (value) {
          emit('update:modelValue', value)
        }
      })
  
      const transitionClass = computed(() => {
        if (!props.transition) {
          return {}
        }
  
        return {
          ...ui.value.transition
        }
      })
  
      function close (value: boolean) {
        if (props.preventClose) {
          emit('close-prevented')
  
          return
        }
  
        isOpen.value = value
  
        emit('close')
      }
  
      const onAfterLeave = () => {
        emit('after-leave')
      }
  
    //   provideUseId(() => useId())
  
      return {
        // eslint-disable-next-line vue/no-dupe-keys
        ui,
        attrs,
        isOpen,
        transitionClass,
        onAfterLeave,
        close
      }
    }
  })
  </script>