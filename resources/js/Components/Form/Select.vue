<template>
    <div :class="ui.wrapper">
        <select
            :id="inputId"
            :name="name"
            :value="modelValue"
            :required="required"
            :disabled="disabled"
            :class="selectClass"
            v-bind="attrs"
            @input="onInput"
            @change="onChange"
        >
            <template
                v-for="(option, index) in normalizedOptionsWithPlaceholder"
            >
                <optgroup
                    v-if="option.children"
                    :key="`${option[valueAttribute]}-optgroup-${index}`"
                    :value="option[valueAttribute]"
                    :label="option[optionAttribute]"
                >
                    <option
                        v-for="(childOption, index2) in option.children"
                        :key="`${childOption[valueAttribute]}-${index}-${index2}`"
                        :value="childOption[valueAttribute]"
                        :selected="
                            childOption[valueAttribute] === normalizedValue
                        "
                        :disabled="childOption.disabled"
                        v-text="childOption[optionAttribute]"
                    />
                </optgroup>
                <option
                    v-else
                    :key="`${option[valueAttribute]}-${index}`"
                    :value="option[valueAttribute]"
                    :selected="option[valueAttribute] === normalizedValue"
                    :disabled="option.disabled"
                    v-text="option[optionAttribute]"
                />
            </template>
        </select>

        <span
            v-if="(isLeading && leadingIconName) || $slots.leading"
            :class="leadingWrapperIconClass"
        >
            <slot name="leading" :disabled="disabled" :loading="loading">
                <Icon :name="loadingIcon" type="custom" :class="leadingIconClass" />
            </slot>
        </span>

        <span
            v-if="(isTrailing && trailingIconName) || $slots.trailing"
            :class="trailingWrapperIconClass"
        >
            <slot name="trailing" :disabled="disabled" :loading="loading">
                <Icon
                    :name="trailingIconName"
                    :class="trailingIconClass"
                    aria-hidden="true"
                />
            </slot>
        </span>
    </div>
</template>

<script lang="ts">
import { computed, toRef, defineComponent } from "vue";
import type { PropType, ComputedRef } from "vue";
import { twMerge, twJoin } from "tailwind-merge";
import Icon  from "@/Components/Icon.vue";
import { useUI } from "@/Composables/useUI";
import { useFormGroup } from "@/Composables/useFormGroup";
import { mergeConfig, get } from "@/Composables/utils";
import { useInjectButtonGroup } from "@/Composables/useButtonGroup";
import type { CustomIconName, IconName, Strategy } from '@/types'
 

const config = {
    wrapper: "relative",
    base: "relative block w-full disabled:cursor-not-allowed disabled:opacity-75 focus:outline-none border-0",
    form: "form-select",
    placeholder: "text-gray-400 dark:text-gray-500",
    rounded: "rounded-md",
    file: {
        base: "file:mr-1.5 file:font-medium file:text-gray-500 dark:file:text-gray-400 file:bg-transparent file:border-0 file:p-0 file:outline-none",
    },
    size: {
        "2xs": "text-xs",
        xs: "text-xs",
        sm: "text-sm",
        md: "text-sm",
        lg: "text-sm",
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
    },
    default: {
        size: "sm",
        color: "white",
        variant: "outline",
        loadingIcon: "LoadingIcon",
        trailingIcon: "MagnifyingGlassIcon",
    },
};

 type SelectSize = keyof typeof config.size 
 type SelectColor = keyof typeof config.color 
 type SelectVariant = keyof typeof config.variant 

export default defineComponent({
    components: {
        Icon,
    },      
    inheritAttrs: false,
    props: {
        modelValue: {
            type: [String, Number, Object],
            default: "",
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
        icon: {
            type: String as PropType<IconName>,
            default: null,
        },
        loadingIcon: {
            type: String as PropType<CustomIconName>,
            default: () => config.default.loadingIcon,
        },
        leadingIcon: {
            type: String,
            default: null,
        },
        trailingIcon: {
            type: String as PropType<IconName>,
            default: () => config.default.trailingIcon,
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
        options: {
            type: Array,
            default: () => [],
        },
        size: {
            type: String as PropType<SelectSize>,
            default: null,
            validator(value: string) {
                return Object.keys(config.size).includes(value);
            },
        },
        color: {
            type: String as PropType<SelectColor>,
            default: () => config.default.color,
            validator(value: string) {
                return [
                    ...Object.keys(config.color),
                ].includes(value);
            },
        },
        variant: {
            type: String as PropType<SelectVariant>,
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
        optionAttribute: {
            type: String,
            default: "label",
        },
        valueAttribute: {
            type: String,
            default: "value",
        },
        selectClass: {
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
    },
    emits: ["update:modelValue", "change"],
    setup(props, { emit, slots }) {
        const { ui, attrs } = useUI(
            "select",
            toRef(props, "ui"),
            config,
            toRef(props, "class")
        );

        const { size: sizeButtonGroup, rounded } = useInjectButtonGroup({
            ui,
            props,
        });

        const {
            emitFormChange,
            inputId,
            color,
            size: sizeFormGroup,
            name,
        } = useFormGroup(props, config);

        const size = computed(
            () => sizeButtonGroup.value ?? sizeFormGroup.value
        );

        const onInput = (event: Event) => {
            emit("update:modelValue", (event.target as HTMLInputElement).value);
        };

        const onChange = (event: Event) => {
            emit("change", (event.target as HTMLInputElement).value);
            emitFormChange();
        };

        const guessOptionValue = (option: any) => {
            return get(option, props.valueAttribute, "");
        };

        const guessOptionText = (option: any) => {
            return get(option, props.optionAttribute, "");
        };

        const normalizeOption = (option: any) => {
            if (["string", "number", "boolean"].includes(typeof option)) {
                return {
                    [props.valueAttribute]: option,
                    [props.optionAttribute]: option,
                };
            }

            return {
                ...option,
                [props.valueAttribute]: guessOptionValue(option),
                [props.optionAttribute]: guessOptionText(option),
            };
        };

        const normalizedOptions = computed(() => {
            return props.options.map((option) => normalizeOption(option));
        });

        const normalizedOptionsWithPlaceholder: ComputedRef<
            { disabled?: boolean; children: { disabled?: boolean }[] }[]
        > = computed(() => {
            if (!props.placeholder) {
                return normalizedOptions.value;
            }

            return [
                {
                    [props.valueAttribute]: "",
                    [props.optionAttribute]: props.placeholder,
                    disabled: true,
                },
                ...normalizedOptions.value,
            ];
        });

        const normalizedValue = computed(() => {
            const normalizeModelValue = normalizeOption(props.modelValue);
            const foundOption = normalizedOptionsWithPlaceholder.value.find(
                (option) =>
                    option[props.valueAttribute] ===
                    normalizeModelValue[props.valueAttribute]
            );
            if (!foundOption) {
                return "";
            }

            return foundOption[props.valueAttribute];
        });

        const selectClass = computed(() => {
            const variant =
                ui.value.color?.[color.value as string]?.[
                    props.variant as string
                ] || ui.value.variant[props.variant];

            return twMerge(
                twJoin(
                    ui.value.base,
                    ui.value.form,
                    rounded.value,
                    ui.value.size[size.value],
                    props.padded ? ui.value.padding[size.value] : "p-0",
                    variant?.replaceAll("{color}", color.value),
                    (isLeading.value || slots.leading) &&
                        ui.value.leading.padding[size.value],
                    (isTrailing.value || slots.trailing) &&
                        ui.value.trailing.padding[size.value]
                ),
                props.placeholder && !props.modelValue && ui.value.placeholder,
                props.selectClass
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

        const trailingIconName = computed<IconName>(() => {
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
                ui.value.icon.trailing.padding[size.value]
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
            normalizedOptionsWithPlaceholder,
            normalizedValue,
            isLeading,
            isTrailing,
            // eslint-disable-next-line vue/no-dupe-keys
            selectClass,
            leadingIconName,
            leadingIconClass,
            leadingWrapperIconClass,
            trailingIconName,
            trailingIconClass,
            trailingWrapperIconClass,
            onInput,
            onChange,
        };
    },
});
</script>

<style scoped>
.form-select {
    background-image: none;
}
</style>
