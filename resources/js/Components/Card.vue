<template>
    <component
      :is="$attrs.onSubmit ? 'form' : as"
      :class="cardClass"
      v-bind="attrs"
    >
      <div v-if="$slots.header" :class="[ui.header.base, ui.header.padding, ui.header.background]">
        <slot name="header" />
      </div>
      <div v-if="$slots.default" :class="[ui.body.base, ui.body.padding, ui.body.background]">
        <slot />
      </div>
      <div v-if="$slots.footer" :class="[ui.footer.base, ui.footer.padding, ui.footer.background]">
        <slot name="footer" />
      </div>
    </component>
  </template>
  
  <script lang="ts">
  import { computed, toRef, defineComponent } from 'vue'
  import type { PropType } from 'vue'
  import { twMerge, twJoin } from 'tailwind-merge'
  import { useUI } from '@/Composables/useUI';
  import type { Strategy } from '@/types';

  
  const config =  {
        base: '',
        background: 'bg-white dark:bg-gray-900',
        divide: 'divide-y divide-gray-200 dark:divide-gray-800',
        ring: 'ring-1 ring-gray-200 dark:ring-gray-800',
        rounded: 'rounded-lg',
        shadow: 'shadow',
        body: {
            base: '',
            background: '',
            padding: 'px-4 py-5 sm:p-6'
        },
        header: {
            base: '',
            background: '',
            padding: 'px-4 py-5 sm:px-6'
        },
        footer: {
            base: '',
            background: '',
            padding: 'px-4 py-4 sm:px-6'
        }
    }
  
  export default defineComponent({
    inheritAttrs: false,
    props: {
      as: {
        type: String,
        default: 'div'
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
    setup (props) {
      const { ui, attrs } = useUI('card', toRef(props, 'ui'), config)
  
      const cardClass = computed(() => {
        return twMerge(twJoin(
          ui.value.base,
          ui.value.rounded,
          ui.value.divide,
          ui.value.ring,
          ui.value.shadow,
          ui.value.background
        ), props.class)
      })
  
      return {
        // eslint-disable-next-line vue/no-dupe-keys
        ui,
        attrs,
        cardClass
      }
    }
  })
  </script>