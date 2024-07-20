<template>
    <div :class="ui.wrapper">
        <input 
            v-bind="attrs" 
            :id="labelId" 
            type="checkbox" 
            :value="value" 
            v-model="proxyChecked"
            :class="[ui.checkbox.base, ui.checkbox.size, ui.checkbox.color]" 
        />
        <label :for="labelId" :class="[ui.label.base, ui.label.size, ui.label.color]">{{ label }}</label>
    </div>
</template>
<script setup lang="ts">
import { useUI } from '@/Composables/useUI';
import { computed, toRef } from 'vue';

const emit = defineEmits(['update:checked']);

const config = {
    wrapper: 'flex items-center my-4',
    checkbox: {
        base: 'rounded focus:ring-2',
        size: 'w-4 h-4',
        color: 'text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600'
    },
    label: {
        base: 'ms-2',
        size: 'text-sm font-medium',
        color: 'text-gray-900 dark:text-gray-300'
    }
};

const props = defineProps<{
    modelValue: boolean;
    value?: any;
    label?: string; 
    ui?: any
}>();

const { ui, attrs } = useUI('checkbox', toRef(props, 'ui'), config)

const proxyChecked = computed({
    get() {
        return props.modelValue;
    },

    set(val) {
        emit('update:checked', val);
    },
});

const labelId = props.label.replace(/\d*\s*/, '').replaceAll(' ', '_').toLowerCase()

</script>