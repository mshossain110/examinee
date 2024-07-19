<template>
    <div :class="ui.wrapper">
        <input 
            v-bind="attrs" 
            id="default-checkbox" 
            type="checkbox" 
            :value="value" 
            v-model="proxyChecked"
            :class="[ui.checkbox.base, ui.checkbox.size, ui.checkbox.color]" 
        />
        <label for="default-checkbox" :class="[ui.label.base, ui.label.size, ui.label.color]">Default checkbox</label>
    </div>
</template>
<script setup lang="ts">
import { useUI } from '@/Composables/useUI';
import { computed, toRef } from 'vue';

const emit = defineEmits(['update:checked']);

const config = {
    wrapper: 'flex items-center mb-4',
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

const props = defineProps < {
    checked: boolean;
    value?: any;
    label?: string; 
    ui?: any
} > ();

const { ui, attrs } = useUI('checkbox', toRef(props, 'ui'), config)

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});

</script>