<template>
    <p id="">
        {{ showFullText ? description : description.substring(0, numberOfChar) }}
        <a class="inline-block text-gray-700 dark:text-gray-500" v-if="!showFullText" @click.prevent="showFullText = true">...more</a>
        <a class="inline-block text-red-300 dark:text-red-500" v-if="showFullText" @click.prevent="showFullText = false">(hide)</a>
    </p>
</template>

<script setup lang="ts">
import { ref  } from 'vue';
const props = withDefaults(defineProps<{
    description: string;
    numberOfChar?: number;
    fullText?: boolean
}>(),
{
    numberOfChar: 50,
    fullText: false
})

const showFullText = ref(props.fullText);

</script>