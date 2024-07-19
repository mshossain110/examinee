<template>
    <nav :class="ui.wrapper" aria-label="Breadcrumb">
        <Link :href="route('admin.dashboard')" :class="breadcrumbClass">
            <svg
                class="w-3 h-3 me-2.5"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 20 20"
            >
                <path
                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"
                />
            </svg>
            Dashboard
        </Link>
        <div
            v-for="(item, index) in items"
            :key="index"
            class="flex items-center"
        >
            <svg
                class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 6 10"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="m1 9 4-4-4-4"
                />
            </svg>
            <span
                v-if="item.current"
                :class="breadcrumbClass"
            >
                {{ item.name }}
            </span>
            <Link v-else :href="item.href" :class="breadcrumbClass">
                {{ item.name }}
            </Link>
        </div>
    </nav>
</template>

<script lang="ts">
import { Link } from "@inertiajs/vue3";
import { LinkType } from "@/types";
import { PropType } from "vue";
import { useUI } from "@/Composables/useUI";
import { computed, toRef, defineComponent } from "vue";
import { twMerge, twJoin } from "tailwind-merge";

const config = {
    wrapper: "flex",
    base: "inline-flex items-center",
    size: {
        "2xs": "text-xs",
        xs: "text-xs",
        sm: "text-sm",
        md: "text-md",
        lg: "text-lg",
        xl: "text-base",
    },
    gap: {
        "2xs": "ms-1",
        xs: "ms-1",
        sm: "ms-1",
        md: "ms-1",
        lg: "ms-2",
        xl: "ms-3",
    },
    color: "text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white",
    default: {
        size: "sm",
    },
};

export default defineComponent({
    name: "Breadcrumbs",
    components: {
        Link,
    },
    props: {
        items: {
            type: Object as PropType<LinkType[]>,
            required: true,
        },
        size: {
            type: String,
            default: () => config.default.size,
            validator(value: string) {
                return Object.keys(config.size).includes(value);
            },
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
    setup(props, { slots }) {
        const { ui, attrs } = useUI("breadcrumb", toRef(props, "ui"), config);

        const breadcrumbClass = computed(() => {
            return twMerge(
                twJoin(
                    ui.value.base,
                    ui.value.size[props.size],
                    ui.value.gap[props.size],
                    ui.value.color
                ),
                props.class
            );
        });

        return {
            ui,
            breadcrumbClass,
        };
    },
});
</script>
