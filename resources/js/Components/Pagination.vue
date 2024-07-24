<template>
    <div :class="ui.wrapper" v-bind="attrs">
        <nav aria-label="pagination" class="inline-flex -space-x-px text-sm">
            <Link
                v-for="(page, index) of pages"
                :key="`page-${index}`"
                :href="page.url"
                :class="[
                    buttonClass,
                    { '!bg-blue-500 !text-white': page.active },
                ]"
                v-html="page.label"
                preserve-state
            >
            </Link>
        </nav>
    </div>
</template>

<script lang="ts">
import {
    ChevronDoubleLeftIcon,
    ChevronDoubleRightIcon,
} from "@heroicons/vue/24/outline";
import { Link } from "@inertiajs/vue3";
import { computed, toRef, defineComponent } from "vue";
import type { PropType } from "vue";
import Button from "@/Components/Button.vue";
import { useUI } from "@/Composables/useUI";
import type { LaravelPagination, PaginationLink } from "@/types";
import { twMerge, twJoin } from "tailwind-merge";

const config = {
    wrapper: "flex items-center -space-x-px",
    base: "flex items-center justify-center",
    rounded: "first:rounded-s-md last:rounded-e-md",
    size: {
        "2xs": "text-xs",
        xs: "text-xs",
        sm: "text-sm",
        md: "text-md",
        lg: "text-lg",
        xl: "text-base",
    },
    padding: {
        "2xs": "px-2 py-1",
        xs: "px-2.5 py-1.5",
        sm: "px-2.5 py-1.5",
        md: "px-3 py-2",
        lg: "px-3.5 py-2.5",
        xl: "px-3.5 py-2.5",
    },
    color: "text-gray-500 bg-white border border-e-0 border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white",
    default: {
        size: "sm",
    },
};

// flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white

export default defineComponent({
    components: {
        Button,
        ChevronDoubleLeftIcon,
        ChevronDoubleRightIcon,
        Link,
    },
    inheritAttrs: false,
    props: {
        paginate: {
            type: Object as PropType<LaravelPagination>,
            required: true,
        },
        pagename: {
            type: String,
            default: () => "page",
        },
        max: {
            type: Number,
            default: 7,
            validate(value) {
                return value >= 5 && value < Number.MAX_VALUE;
            },
        },

        size: {
            type: String,
            default: () => config.default.size,
            validator(value: string) {
                return Object.keys(config.size).includes(value);
            },
        },
        showFirst: {
            type: Boolean,
            default: false,
        },
        showLast: {
            type: Boolean,
            default: false,
        },
        divider: {
            type: String,
            default: "…",
        },
        class: {
            type: [String, Object, Array] as PropType<any>,
            default: () => "",
        },
        ui: {
            type: Object as PropType<Partial<typeof config>>,
            default: () => ({}),
        },
    },
    emits: ["update:modelValue"],
    setup(props, { emit }) {
        const { ui, attrs } = useUI(
            "pagination",
            toRef(props, "ui"),
            config,
            toRef(props, "class")
        );

        const currentPage = computed({
            get() {
                return props.paginate.current_page;
            },
            set(value) {
                emit("update:modelValue", value);
            },
        });

        const pages = computed(() => props.paginate.links);

        const buttonClass = computed(() => {
            return twMerge(
                twJoin(
                    ui.value.base,
                    ui.value.rounded,
                    ui.value.size[props.size],
                    ui.value.padding[props.size],
                    ui.value.color
                ),
                props.class
            );
        });

        const canGoFirstOrPrev = computed(() => currentPage.value > 1);
        const canGoLastOrNext = computed(
            () => currentPage.value < pages.value.length
        );

        function onClickFirst() {
            if (!canGoFirstOrPrev.value) {
                return;
            }

            currentPage.value = 1;
        }

        function onClickLast() {
            if (!canGoLastOrNext.value) {
                return;
            }

            currentPage.value = pages.value.length;
        }

        function onClickPage(page: number | string) {
            if (typeof page === "string") {
                return;
            }

            currentPage.value = page;
        }

        function onClickPrev() {
            if (!canGoFirstOrPrev.value) {
                return;
            }

            currentPage.value--;
        }

        function onClickNext() {
            if (!canGoLastOrNext.value) {
                return;
            }

            currentPage.value++;
        }

        return {
            // eslint-disable-next-line vue/no-dupe-keys
            ui,
            attrs,
            buttonClass,
            currentPage,
            pages,
            canGoLastOrNext,
            canGoFirstOrPrev,
            onClickPrev,
            onClickNext,
            onClickPage,
            onClickFirst,
            onClickLast,
        };
    },
});
</script>
