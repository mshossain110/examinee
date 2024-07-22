<template>
    <li
        class="relative rounded-lg border border-gray-300 px-6 py-5 shadow-sm items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
    >
        <div class="flex">
            <div class="flex-shrink-0 mr-3">
                <Icon name="AcademicCapIcon" class="w-6 h-6" />
            </div>
            <div class="flex-1 min-w-0">
                {{ exam.title }}
            </div>
            <div class="flex-shrink-0">
                <a :href="route('admin.exams.edit', exam.id)" class="inline-block">
                    <Icon name="PencilIcon" class="w-6 h-6" />
                </a>
            </div>
        </div>
    </li>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Exam } from '@/types';
import LessonForm from './LessonForm.vue';
import Icon from '@/Components/Icon.vue';

defineProps<{
    exam: Exam
}>()

const showForm = ref(false)
</script>
