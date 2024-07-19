<template>
    <div :class="ui.wrapper" v-bind="attrs">
        <table :class="[ui.base, ui.divide]">
            <slot v-if="$slots.caption || caption" name="caption">
                <caption :class="ui.caption">
                    {{ caption }}
                </caption>
            </slot>

            <thead :class="ui.thead">
                <tr :class="ui.tr.base">
                    <th v-if="modelValue" scope="col" class="p-2 text-center">
                        <input :value="indeterminate || selected.length === rows.length" :indeterminate="indeterminate" aria-label="Select all" @change="onChange"  type="checkbox" v-bind="ui.checkbox" />
                    </th>

                    <th v-for="(column, index) in columns" :key="index" scope="col"
                        :class="[ui.th.base, ui.th.padding, ui.th.color, ui.th.font, ui.th.size, column.class]"
                        :aria-sort="getAriaSort(column)">
                        <slot :name="`${column.key}-header`" :column="column" :sort="sort" :on-sort="onSort">
                            <button v-if="column.sortable" @click="onSort(column)" v-bind="{ ...(ui.sortButton || {}), ...sortButton }">
                                <span>{{ column[columnAttribute] }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 ms-1.5 opacity-0 group-hover:opacity-100">
                                    <path stroke-linecap="round" stroke-linejoin="round" :d="getSortIconPath(column)" />
                                </svg>
                            </button>
                            <span v-else>{{ column[columnAttribute] }}</span>
                        </slot>
                    </th>
                </tr>
            </thead>
            <tbody :class="ui.tbody">
                <tr v-if="loadingState && loading && !rows.length">
                    <td :colspan="columns.length + (modelValue ? 1 : 0)">
                        <slot name="loading-state">
                            <div :class="ui.loadingState.wrapper">
                                <svg width="36" height="36" :class="ui.loadingState.icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity=".25"/><path d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z" class="spinner_ajPY"/></svg>
                                <p :class="ui.loadingState.label">
                                    {{ loadingState.label }}
                                </p>
                            </div>
                        </slot>
                    </td>
                </tr>

                <tr v-else-if="emptyState && !rows.length">
                    <td :colspan="columns.length + (modelValue ? 1 : 0)">
                        <slot name="empty-state">
                            <div :class="ui.emptyState.wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                </svg>

                                <p :class="ui.emptyState.label">
                                    {{ emptyState.label }}
                                </p>
                            </div>
                        </slot>
                    </td>
                </tr>

                <template v-else>
                    <tr v-for="(row, index) in rows" :key="index"
                        :class="[ui.tr.base, isSelected(row) && ui.tr.selected, $attrs.onSelect && ui.tr.active, row?.class]"
                        @click="() => onSelect(row)">
                        <td v-if="modelValue" class="p-2 text-center">
                            <input v-model="selected" :value="row" aria-label="Select row" @click.stop  type="checkbox" v-bind="ui.checkbox">
                        </td>

                        <td v-for="(column, subIndex) in columns" :key="subIndex"
                            :class="[ui.td.base, ui.td.padding, ui.td.color, ui.td.font, ui.td.size, row[column.key]?.class]">
                            <slot :name="`${column.key}-data`" :column="column" :row="row" :index="index"
                                :get-row-data="(defaultValue: any) => getRowData(row, column.key, defaultValue)">
                                {{ getRowData(row, column.key) }}
                            </slot>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</template>
<script lang="ts">
import { PropType, AriaAttributes, computed, defineComponent, toRaw, toRef } from 'vue';
import { useVModel } from '@vueuse/core';
import { useUI } from '@/Composables/useUI';
import { defu } from 'defu';
import { upperFirst } from 'lodash';
import { mergeConfig, get } from '@/Composables/utils';
import type { Strategy } from '@/types';

let config = {
    wrapper: 'relative overflow-x-auto flex-1 my-4',
    base: 'min-w-full table-fixed',
    divide: 'divide-y divide-gray-300 dark:divide-gray-700',
    thead: 'relative',
    tbody: 'divide-y divide-gray-200 dark:divide-gray-800',
    caption: 'sr-only',
    tr: {
      base: '',
      selected: 'bg-gray-50 dark:bg-gray-800/50',
      active: 'hover:bg-gray-50 dark:hover:bg-gray-800/50 cursor-pointer'
    },
    th: {
      base: 'text-left rtl:text-right',
      padding: 'px-4 py-4',
      color: 'text-gray-900 dark:text-white',
      font: 'font-semibold',
      size: 'text-sm',
    },
    td: {
      base: 'whitespace-nowrap',
      padding: 'px-4 py-4',
      color: 'text-gray-500 dark:text-gray-400',
      font: '',
      size: 'text-sm'
    },
    checkbox: {
      class: "w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600",
    },
    loadingState: {
      wrapper: 'flex flex-col items-center justify-center flex-1 px-6 py-14 sm:px-14',
      label: 'text-sm text-center text-gray-900 dark:text-white',
      icon: 'w-6 h-6 mx-auto text-gray-400 dark:text-gray-500 mb-4 animate-spin'
    },
    emptyState: {
      wrapper: 'flex flex-col items-center justify-center flex-1 px-6 py-14 sm:px-14',
      label: 'text-sm text-center text-gray-900 dark:text-white',
      icon: 'w-6 h-6 mx-auto text-gray-400 dark:text-gray-500 mb-4',
    },
    progress: {
      wrapper: 'absolute inset-x-0 -bottom-[0.5px] p-0',
      color: 'primary' as const,
      animation: 'carousel' as const
    },
    sortButton: {
      trailing: true,
      square: true,
      color: 'gray' as const,
      variant: 'ghost' as const,
      class: 'flex items-center gap-x-1 focus:outline-none'
    },
    sortIcon: "M3 7.5 7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5",
    sortAscIcon: "M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0-3.75-3.75M17.25 21 21 17.25",
    sortDescIcon: "M3 4.5h14.25M3 9h9.75M3 13.5h5.25m5.25-.75L17.25 9m0 0L21 12.75M17.25 9v12"
  };

 config = mergeConfig<typeof config>('merge', config)

function defaultComparator<T>(a: T, z: T): boolean {
    return a === z
}

function defaultSort(a: any, b: any, direction: 'asc' | 'desc') {
    if (a === b) {
        return 0
    }

    if (direction === 'asc') {
        return a < b ? -1 : 1
    } else {
        return a > b ? -1 : 1
    }
}

interface Column {
    key: string
    sortable?: boolean
    sort?: (a: any, b: any, direction: 'asc' | 'desc') => number
    direction?: 'asc' | 'desc'
    class?: string
    [key: string]: any
}

export default defineComponent({
    inheritAttrs: false,
    props: {
        modelValue: {
            type: Array,
            default: null
        },
        by: {
            type: [String, Function],
            default: () => defaultComparator
        },
        rows: {
            type: Array as PropType<{ [key: string]: any }[]>,
            default: () => []
        },
        columns: {
            type: Array as PropType<Column[]>,
            default: null
        },
        columnAttribute: {
            type: String,
            default: 'label'
        },
        sort: {
            type: Object as PropType<{ column: string, direction: 'asc' | 'desc' }>,
            default: () => ({})
        },
        sortMode: {
            type: String as PropType<'manual' | 'auto'>,
            default: 'auto'
        },
        sortButton: {
            type: Object as PropType<{ icon: string, trailing: string }>,
            default: () => config.sortButton
        },
        sortIcon: {
            type: String,
            default: () => config.sortIcon
        },
        sortAscIcon: {
            type: String,
            default: () => config.sortAscIcon
        },
        sortDescIcon: {
            type: String,
            default: () => config.sortDescIcon
        },
        loading: {
            type: Boolean,
            default: false
        },
        loadingState: {
            type: Object as PropType<{ icon: string, label: string }>,
            default: () => config.loadingState
        },
        emptyState: {
            type: Object as PropType<{ icon: string, label: string }>,
            default: () => config.emptyState
        },
        caption: {
            type: String,
            default: null
        },
        progress: {
            type: Object,
            default: () => null
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
    emits: ['update:modelValue', 'update:sort'],
    setup(props, { emit, attrs: $attrs }) {
        const { ui, attrs } = useUI('table', toRef(props, 'ui'), config, toRef(props, 'class'))

        const columns = computed(() => props.columns ?? Object.keys(props.rows[0] ?? {}).map((key) => ({ key, label: upperFirst(key), sortable: false, class: undefined, sort: defaultSort })))

        const sort = useVModel(props, 'sort', emit, { passive: true, defaultValue: defu({}, props.sort, { column: 'abc', direction: 'asc' }) }); 

        const savedSort = { column: 'bc', direction: 'desc' }

        const rows = computed(() => {
            if (!sort.value?.column || props.sortMode === 'manual') {
                return props.rows
            }

            const { column, direction } = sort.value

            return props.rows.slice().sort((a, b) => {
                const aValue = get(a, column)
                const bValue = get(b, column)

                const sort = columns.value.find((col) => col.key === column)?.sort ?? defaultSort

                return sort(aValue, bValue, direction)
            })
        })

        const selected = computed({
            get() {
                return props.modelValue
            },
            set(value) {
                emit('update:modelValue', value)
            }
        })

        const indeterminate = computed(() => selected.value && selected.value.length > 0 && selected.value.length < props.rows.length)

        const emptyState = computed(() => {
            if (props.emptyState === null) return null
            return { ...ui.value.emptyState, ...props.emptyState }
        })

        const loadingState = computed(() => {
            if (props.loadingState === null) return null
            return { ...ui.value.loadingState, ...props.loadingState }
        })

        function compare(a: any, z: any) {
            if (typeof props.by === 'string') {
                const property = props.by as unknown as any
                return a?.[property] === z?.[property]
            }
            return props.by(a, z)
        }

        function isSelected(row: any) {
            if (!props.modelValue) {
                return false
            }

            return selected.value.some((item) => compare(toRaw(item), toRaw(row)))
        }

        function onSort(column: { key: string, direction?: 'asc' | 'desc' }) {
            if (sort.value.column === column.key) {
                const direction = !column.direction || column.direction === 'asc' ? 'desc' : 'asc'

                if (sort.value.direction === direction) {
                    /** Todo */
                    // sort.value = defu(savedSort, { column: 'abc', direction: 'asc' })
                } else {
                    sort.value = { column: sort.value.column, direction: sort.value.direction === 'asc' ? 'desc' : 'asc' }
                }
            } else {
                sort.value = { column: column.key, direction: column.direction || 'asc' }
            }
        }

        function onSelect(row: any) {
            if (!$attrs.onSelect) {
                return
            }

            // @ts-ignore
            $attrs.onSelect(row)
        }

        function selectAllRows() {
            props.rows.forEach((row) => {
                // If the row is already selected, don't select it again
                if (isSelected(row)) {
                    return
                }

                // @ts-ignore
                selected.value.push(row)
            })
        }

        function onChange (event: Event) {
            const checked = (event.target as HTMLInputElement).checked
            if (checked) {
                selectAllRows()
            } else {
                selected.value = []
            }
        }

        function getRowData(row: Object, rowKey: string | string[], defaultValue: any = '') {
            return get(row, rowKey, defaultValue)
        }

        function getAriaSort(column: Column): AriaAttributes['aria-sort'] {
            if (!column.sortable) {
                return undefined
            }

            if (sort.value.column !== column.key) {
                return 'none'
            }

            if (sort.value.direction === 'asc') {
                return 'ascending'
            }

            if (sort.value.direction === 'desc') {
                return 'descending'
            }

            return undefined
        }

        function getSortIconPath(column: Column): string {

            if (sort.value.column !== column.key) {
                return props.sortIcon
            }

            if (sort.value.direction === 'asc') {
                return props.sortAscIcon
            }

            if (sort.value.direction === 'desc') {
                return props.sortDescIcon
            }

            return props.sortIcon
        }

        return {
            // eslint-disable-next-line vue/no-dupe-keys
            ui,
            attrs,
            // eslint-disable-next-line vue/no-dupe-keys
            sort,
            // eslint-disable-next-line vue/no-dupe-keys
            columns,
            // eslint-disable-next-line vue/no-dupe-keys
            rows,
            selected,
            indeterminate,
            // eslint-disable-next-line vue/no-dupe-keys
            emptyState,
            // eslint-disable-next-line vue/no-dupe-keys
            loadingState,
            isSelected,
            onSort,
            onSelect,
            onChange,
            getRowData,
            getAriaSort,
            getSortIconPath
        }
    }

});
</script>
<style scoped>
th svg {
    opacity: 0;
}
th:hover svg,
th[aria-sort='ascending'] svg,
th[aria-sort='descending'] svg {
    opacity: 1;
}
.spinner_ajPY{transform-origin:center;animation:spinner_AtaB .75s infinite linear}@keyframes spinner_AtaB{100%{transform:rotate(360deg)}}
</style>