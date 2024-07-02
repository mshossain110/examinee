import { computed, toValue, useAttrs } from 'vue'
import type { Ref } from 'vue'
import { mergeConfig, omit, get } from '@/Services/utils';
import type { Strategy } from '@/types'

export const useUI = <T>(key: string, $ui?: Ref<Partial<T> & { strategy?: Strategy } | undefined>, $config?: Ref<T> | T, $wrapperClass?: Ref<string>) => {
  const $attrs = useAttrs()

  const ui = computed(() => {
  const _ui = toValue($ui)
  const _config = toValue($config)
  const _wrapperClass = toValue($wrapperClass)

    return mergeConfig<T>(
      _ui?.strategy || 'merge',
      _wrapperClass ? { wrapper: _wrapperClass } : {},
      _ui || {},
      _config || {}
    )
  })

  const attrs = computed(() => omit($attrs, ['class']))

  return {
    ui,
    attrs
  }
}