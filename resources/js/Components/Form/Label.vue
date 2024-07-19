<template>
    <div :class="ui.wrapper" v-bind="attrs">
      <div :class="ui.inner">
        <div v-if="label || $slots.label" :class="[ui.label.wrapper, size]">
          <label :for="inputId" :class="[ui.label.base, required ? ui.label.required : '']">
            <slot v-if="$slots.label" name="label" v-bind="{ error, label, name, hint, description, help }" />
            <template v-else>{{ label }}</template>
          </label>
          <span v-if="hint || $slots.hint" :class="[ui.hint]">
            <slot v-if="$slots.hint" name="hint" v-bind="{ error, label, name, hint, description, help }" />
            <template v-else>{{ hint }}</template>
          </span>
        </div>
  
        <p v-if="description || $slots.description" :class="[ui.description, size]">
          <slot v-if="$slots.description" name="description" v-bind="{ error, label, name, hint, description, help }" />
          <template v-else>
            {{ description }}
          </template>
        </p>
      </div>
  
      <div :class="[label ? ui.container : '']">
        <slot v-bind="{ error }" />
  
        <p v-if="typeof error === 'string' && error" :class="[ui.error, size]">
          <slot v-if="$slots.error" name="error" v-bind="{ error, label, name, hint, description, help }" />
          <template v-else>
            {{ error }}
          </template>
        </p>
        <p v-else-if="help || $slots.help" :class="[ui.help, size]">
          <slot v-if="$slots.help" name="help" v-bind="{ error, label, name, hint, description, help }" />
          <template v-else>
            {{ help }}
          </template>
        </p>
      </div>
    </div>
  </template>
  
  <script lang="ts">
  import { computed, defineComponent, provide, inject, ref, toRef } from 'vue'
  import type { Ref, PropType } from 'vue'
  import { useUI } from '@/Composables/useUI';
  import { useId } from '@/Composables/utils';
  import type { Strategy } from '@/types';
  import type { FormError, InjectedFormGroupValue, Sizes } from '@/types'

  const config = {
  wrapper: '',
  inner: '',
  label: {
    wrapper: 'flex content-center items-center justify-between',
    base: 'block font-medium text-gray-700 dark:text-gray-200',
    // eslint-disable-next-line quotes
    required: `after:content-['*'] after:ms-0.5 after:text-red-500 dark:after:text-red-400`
  },
  size: {
    '2xs': 'text-xs',
    xs: 'text-xs',
    sm: 'text-sm',
    md: 'text-sm',
    lg: 'text-sm',
    xl: 'text-base'
  },
  container: 'mt-1 relative',
  description: 'text-gray-500 dark:text-gray-400',
  hint: 'text-gray-500 dark:text-gray-400',
  help: 'mt-2 text-gray-500 dark:text-gray-400',
  error: 'mt-2 text-red-500 dark:text-red-400',
  default: {
    size: 'md'
  }
}
  
  export default defineComponent({
    inheritAttrs: false,
    props: {
      name: {
        type: String,
        default: null
      },
      size: {
        type: String as PropType<Sizes>,
        default: null,
        validator (value: string) {
          return Object.keys(config.size).includes(value)
        }
      },
      label: {
        type: String,
        default: null
      },
      description: {
        type: String,
        default: null
      },
      required: {
        type: Boolean,
        default: false
      },
      help: {
        type: String,
        default: null
      },
      error: {
        type: [String, Boolean],
        default: null
      },
      hint: {
        type: String,
        default: null
      },
      class: {
        type: [String, Object, Array] as PropType<any>,
        default: () => ''
      },
      ui: {
        type: Object as PropType<Partial<typeof config> & { strategy?: Strategy }>,
        default: () => ({})
      },
      eagerValidation: {
        type: Boolean,
        default: false
      }
    },
    setup (props) {
      const { ui, attrs } = useUI('formGroup', toRef(props, 'ui'), config, toRef(props, 'class'))
  
      const formErrors = inject<Ref<FormError[]> | null>('form-errors', null)
  
      const error = computed(() => {
        return (props.error && typeof props.error === 'string') || typeof props.error === 'boolean'
          ? props.error
          : formErrors?.value?.find((error) => error.path === props.name)?.message
      })
  
      const size = computed(() => ui.value.size[props.size ?? config.default.size])
      const inputId = ref(useId())
  
      provide<InjectedFormGroupValue>('form-group', {
        error,
        inputId,
        name: computed(() => props.name),
        size: computed(() => props.size),
        eagerValidation: computed(() => props.eagerValidation)
      })
  
      return {
        // eslint-disable-next-line vue/no-dupe-keys
        ui,
        attrs,
        inputId,
        // eslint-disable-next-line vue/no-dupe-keys
        size,
        // eslint-disable-next-line vue/no-dupe-keys
        error
      }
    }
  })
  </script>