<template>
    <li
        class="relative rounded-lg border border-gray-300 px-6 py-5 shadow-sm items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
    >
        <div class="flex">
            <div class="flex-shrink-0 mr-3">
                <Icon name="BookOpenIcon" class="w-6 h-6" />
            </div>
            <div class="flex-1 min-w-0">
                {{ lesson.title }}
            </div>
            <div class="flex-shrink-0">
                <a href="" @click.prevent="showForm = !showForm" class="inline-block">
                    <Icon name="PencilIcon" class="w-6 h-6" />
                </a>
            </div>
        </div>
        
        <LessonForm v-if="showForm" :lesson="lesson"></LessonForm>
    </li>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Lesson } from '@/types';
import LessonForm from './LessonForm.vue';
import Icon from '@/Components/Icon.vue';

defineProps<{
    lesson: Lesson
}>()

const showForm = ref(false)
</script>
