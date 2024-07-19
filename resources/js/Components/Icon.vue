<template>
    <component :is="component" v-bind="attrs"/>
</template>

<script lang="ts" setup>
import { Component, useAttrs } from "vue";
import { HeroIconName, CustomIconName } from "@/types";
import * as solid from "@heroicons/vue/24/solid";
import * as Custom from '@/Components/Icons/index'

interface Props {
    name: HeroIconName | CustomIconName;
    type?: "solid" | "outline" | "custom";
}

const props = withDefaults(defineProps<Props>(), {
    name: "ExclamationCircleIcon",
    type: "solid",
});

const component = solid[props.name] ? solid[props.name] : Custom[props.name];

const attrs = useAttrs();
</script>
