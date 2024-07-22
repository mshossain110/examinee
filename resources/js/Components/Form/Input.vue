<template>
    <div :class="type === 'hidden' ? 'hidden' : ui.wrapper">
        <input
            :id="inputId"
            ref="input"
            :name="name"
            :value="modelValue"
            :type="type"
            :required="required"
            :placeholder="placeholder"
            :disabled="disabled"
            :class="inputClass"
            v-bind="attrs"
            @input="onInput"
            @blur="onBlur"
            @change="onChange"
        />
        <slot />

        <span
            v-if="(isLeading && leadingIconName) || $slots.leading"
            :class="leadingWrapperIconClass"
        >
            <slot name="leading" :disabled="disabled" :loading="loading">
                <svg
                    width="36"
                    height="36"
                    :class="leadingIconClass"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"
                        opacity=".25"
                    />
                    <path
                        d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z"
                        class="spinner_ajPY"
                    />
                </svg>
            </slot>
        </span>

        <span
            v-if="(isTrailing && trailingIconName) || $slots.trailing"
            :class="trailingWrapperIconClass"
        >
            <slot name="trailing" :disabled="disabled" :loading="loading">
                <Icon :name="trailingIconName" :class="trailingIconClass" />
            </slot>
        </span>
    </div>
</template>

<script lang="ts">
import { ref, computed, toRef, onMounted, defineComponent } from "vue";
import type { PropType } from "vue";
import { twMerge, twJoin } from "tailwind-merge";
import { defu } from "defu";
import { useUI } from "@/Composables/useUI";
import { useFormGroup } from "@/Composables/useFormGroup";
import { mergeConfig, looseToNumber } from "@/Composables/utils";
import { useInjectButtonGroup } from "@/Composables/useButtonGroup";
import type { Sizes, InputColor, InputVariant, Strategy, IconName } from "@/types";
import Icon from "@/Components/Icon.vue";

const config = {
    wrapper: "relative",
    base: "relative block w-full disabled:cursor-not-allowed disabled:opacity-75 focus:outline-none border-0",
    form: "form-input",
    rounded: "rounded-md",
    placeholder: "placeholder-gray-400 dark:placeholder-gray-500",
    file: {
        base: "file:mr-1.5 file:font-medium file:text-gray-500 dark:file:text-gray-400 file:bg-transparent file:border-0 file:p-0 file:outline-none",
    },
    size: {
        "2xs": "text-xs",
        xs: "text-xs",
        sm: "text-sm",
        md: "text-md",
        lg: "text-lg",
        xl: "text-base",
    },
    gap: {
        "2xs": "gap-x-1",
        xs: "gap-x-1.5",
        sm: "gap-x-1.5",
        md: "gap-x-2",
        lg: "gap-x-2.5",
        xl: "gap-x-2.5",
    },
    padding: {
        "2xs": "px-2 py-1",
        xs: "px-2.5 py-1.5",
        sm: "px-2.5 py-1.5",
        md: "px-3 py-2",
        lg: "px-3.5 py-2.5",
        xl: "px-3.5 py-2.5",
    },
    leading: {
        padding: {
            "2xs": "ps-7",
            xs: "ps-8",
            sm: "ps-9",
            md: "ps-10",
            lg: "ps-11",
            xl: "ps-12",
        },
    },
    trailing: {
        padding: {
            "2xs": "pe-7",
            xs: "pe-8",
            sm: "pe-9",
            md: "pe-10",
            lg: "pe-11",
            xl: "pe-12",
        },
    },
    color: {
        white: {
            outline:
                "shadow-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-white ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400",
        },
        gray: {
            outline:
                "shadow-sm bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white ring-1 ring-inset ring-gray-300 dark:ring-gray-700 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400",
        },
        red: {
            outline:
                "shadow-sm bg-gray-50 dark:bg-gray-800 text-red-900 dark:text-white ring-1 ring-inset ring-red-300 dark:ring-red-700 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400",
        },
    },
    variant: {
        outline:
            "shadow-sm bg-transparent text-gray-900 dark:text-white ring-1 ring-inset ring-{color}-500 dark:ring-{color}-400 focus:ring-2 focus:ring-{color}-500 dark:focus:ring-{color}-400",
        none: "bg-transparent focus:ring-0 focus:shadow-none",
    },
    icon: {
        base: "flex-shrink-0 text-gray-400 dark:text-gray-500",
        color: "text-{color}-500 dark:text-{color}-400",
        loading: "animate-spin",
        size: {
            "2xs": "h-4 w-4",
            xs: "h-4 w-4",
            sm: "h-5 w-5",
            md: "h-5 w-5",
            lg: "h-5 w-5",
            xl: "h-6 w-6",
        },
        leading: {
            wrapper: "absolute inset-y-0 start-0 flex items-center",
            pointer: "pointer-events-none",
            padding: {
                "2xs": "px-2",
                xs: "px-2.5",
                sm: "px-2.5",
                md: "px-3",
                lg: "px-3.5",
                xl: "px-3.5",
            },
        },
        trailing: {
            wrapper: "absolute inset-y-0 end-0 flex items-center",
            pointer: "",
            padding: {
                "2xs": "px-2",
                xs: "px-2.5",
                sm: "px-2.5",
                md: "px-3",
                lg: "px-3.5",
                xl: "px-3.5",
            },
        },
    },
    default: {
        size: "md",
        color: "blue",
        variant: "outline",
        loadingIcon: "i-heroicons-arrow-path-20-solid",
    },
};

export default defineComponent({
    components: {
        Icon
    },
    inheritAttrs: false,
    props: {
        modelValue: {
            type: [String, Number],
            default: "",
        },
        type: {
            type: String,
            default: "text",
        },
        id: {
            type: String,
            default: null,
        },
        name: {
            type: String,
            default: null,
        },
        placeholder: {
            type: String,
            default: null,
        },
        required: {
            type: Boolean,
            default: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        autofocus: {
            type: Boolean,
            default: false,
        },
        autofocusDelay: {
            type: Number,
            default: 100,
        },
        icon: {
            type: String as PropType<IconName>,
            default: null,
        },
        loadingIcon: {
            type: String as PropType<IconName>,
            default: () => config.default.loadingIcon,
        },
        leadingIcon: {
            type: String as PropType<IconName>,
            default: null,
        },
        trailingIcon: {
            type: String as PropType<IconName>,
            default: null,
        },
        trailing: {
            type: Boolean,
            default: false,
        },
        leading: {
            type: Boolean,
            default: false,
        },
        loading: {
            type: Boolean,
            default: false,
        },
        padded: {
            type: Boolean,
            default: true,
        },
        size: {
            type: String as PropType<Sizes>,
            default: config.default.size,
            validator(value: string) {
                return Object.keys(config.size).includes(value);
            },
        },
        color: {
            type: String as PropType<InputColor>,
            default: () => config.default.color,
            validator(value: string) {
                return [...Object.keys(config.color)].includes(value);
            },
        },
        variant: {
            type: String as PropType<InputVariant>,
            default: () => config.default.variant,
            validator(value: string) {
                return [
                    ...Object.keys(config.variant),
                    ...Object.values(config.color).flatMap((value) =>
                        Object.keys(value)
                    ),
                ].includes(value);
            },
        },
        inputClass: {
            type: String,
            default: null,
        },
        class: {
            type: [String, Object, Array] as PropType<any>,
            default: () => "",
        },
        ui: {
            type: Object as PropType<
                Partial<typeof config> & { strategy?: Strategy }
            >,
            default: () => ({}),
        },
        modelModifiers: {
            type: Object as PropType<{
                trim?: boolean;
                lazy?: boolean;
                number?: boolean;
            }>,
            default: () => ({}),
        },
    },
    emits: ["update:modelValue", "blur", "change"],
    setup(props, { emit, slots }) {
        const { ui, attrs } = useUI(
            "input",
            toRef(props, "ui"),
            config,
            toRef(props, "class")
        );

        const { size: sizeButtonGroup, rounded } = useInjectButtonGroup({
            ui,
            props,
        });

        const {
            emitFormBlur,
            emitFormInput,
            size: sizeFormGroup,
            color,
            inputId,
            name,
        } = useFormGroup(props, config);

        const size = computed<Sizes>(
            () => sizeButtonGroup.value ?? sizeFormGroup.value
        );

        const modelModifiers = ref(
            defu({}, props.modelModifiers, {
                trim: false,
                lazy: false,
                number: false,
            })
        );

        const input = ref<HTMLInputElement | null>(null);

        const autoFocus = () => {
            if (props.autofocus) {
                input.value?.focus();
            }
        };

        // Custom function to handle the v-model properties
        const updateInput = (value: string) => {
            if (modelModifiers.value.trim) {
                value = value.trim();
            }

            if (modelModifiers.value.number || props.type === "number") {
                value = looseToNumber(value);
            }

            emit("update:modelValue", value);
            emitFormInput();
        };

        const onInput = (event: Event) => {
            if (!modelModifiers.value.lazy) {
                updateInput((event.target as HTMLInputElement).value);
            }
        };

        const onChange = (event: Event) => {
            if (props.type === "file") {
                const value = (event.target as HTMLInputElement).files;
                emit("change", value);
            } else {
                const value = (event.target as HTMLInputElement).value;
                emit("change", value);
                if (modelModifiers.value.lazy) {
                    updateInput(value);
                }
                // Update trimmed input so that it has same behavior as native input https://github.com/vuejs/core/blob/5ea8a8a4fab4e19a71e123e4d27d051f5e927172/packages/runtime-dom/src/directives/vModel.ts#L63
                if (modelModifiers.value.trim) {
                    (event.target as HTMLInputElement).value = value.trim();
                }
            }
        };

        const onBlur = (event: FocusEvent) => {
            emitFormBlur();
            emit("blur", event);
        };

        onMounted(() => {
            setTimeout(() => {
                autoFocus();
            }, props.autofocusDelay);
        });

        const inputClass = computed(() => {
            const variant =
                ui.value.color?.[color.value as string]?.[
                    props.variant as string
                ] || ui.value.variant[props.variant];

            return twMerge(
                twJoin(
                    ui.value.base,
                    ui.value.form,
                    rounded.value,
                    ui.value.placeholder,
                    props.type === "file" && ui.value.file.base,
                    ui.value.size[size.value],
                    props.padded ? ui.value.padding[size.value] : "p-0",
                    variant?.replaceAll("{color}", color.value ?? "gray"),
                    (isLeading.value || slots.leading) &&
                        ui.value.leading.padding[size.value],
                    (isTrailing.value || slots.trailing) &&
                        ui.value.trailing.padding[size.value]
                ),
                props.inputClass
            );
        });

        const isLeading = computed(() => {
            return (
                (props.icon && props.leading) ||
                (props.icon && !props.trailing) ||
                (props.loading && !props.trailing) ||
                props.leadingIcon
            );
        });

        const isTrailing = computed(() => {
            return (
                (props.icon && props.trailing) ||
                (props.loading && props.trailing) ||
                props.trailingIcon
            );
        });

        const leadingIconName = computed(() => {
            if (props.loading) {
                return props.loadingIcon;
            }

            return props.leadingIcon || props.icon;
        });

        const trailingIconName = computed(() => {
            if (props.loading && !isLeading.value) {
                return props.loadingIcon;
            }

            return props.trailingIcon || props.icon;
        });

        const leadingWrapperIconClass = computed(() => {
            return twJoin(
                ui.value.icon.leading.wrapper,
                ui.value.icon.leading.pointer,
                ui.value.icon.leading.padding[size.value]
            );
        });

        const leadingIconClass = computed(() => {
            return twJoin(
                ui.value.icon.base,
                color.value &&
                    ui.value.icon.color.replaceAll("{color}", color.value),
                ui.value.icon.size[size.value],
                props.loading && ui.value.icon.loading
            );
        });

        const trailingWrapperIconClass = computed(() => {
            return twJoin(
                ui.value.icon.trailing.wrapper,
                ui.value.icon.trailing.pointer,
                // ui.value.icon.trailing.padding[size.value]
            );
        });

        const trailingIconClass = computed(() => {
            return twJoin(
                ui.value.icon.base,
                color.value &&
                    ui.value.icon.color.replaceAll("{color}", color.value),
                ui.value.icon.size[size.value],
                props.loading && !isLeading.value && ui.value.icon.loading
            );
        });

        return {
            // eslint-disable-next-line vue/no-dupe-keys
            ui,
            attrs,
            // eslint-disable-next-line vue/no-dupe-keys
            name,
            inputId,
            input,
            isLeading,
            isTrailing,
            // eslint-disable-next-line vue/no-dupe-keys
            inputClass,
            leadingIconName,
            leadingIconClass,
            leadingWrapperIconClass,
            trailingIconName,
            trailingIconClass,
            trailingWrapperIconClass,
            onInput,
            onChange,
            onBlur,
        };
    },
});
</script>
