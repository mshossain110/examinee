<template>
    <div class="grid grid-cols-12 gap-6">
        <div
            class="col-span-12 flex flex-col-reverse lg:col-span-4 lg:block 2xl:col-span-3"
        >
            <aside aria-label="Sidebar">
                <div
                    class="px-3 py-4 overflow-y-auto rounded bg-gray-50 dark:bg-gray-800"
                >
                    <ul class="space-y-2">
                        <li>
                            <a
                                :href="exam?.id ? route('admin.exams.edit', exam.id) : route('admin.exams.create')"
                                class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                                :class="[ {'bg-gray-300' : route().current('admin.exams.*', exam?.id)}]"
                            >
                                <span class="ml-3">{{ exam?.id ? 'Edit' : 'Create' }}</span>
                            </a>
                        </li>
                        <template v-if="exam?.id ">
                            <li>
                                <a
                                    :href="route('admin.questions.index', exam.id)"
                                    class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                                    :class="[ {'bg-gray-300' : route().current('admin.questions.*',  exam.id)}]"
                                >
                                    <span class="flex-1 ml-3 whitespace-nowrap"
                                        >Questions</span
                                    >
                                </a>
                            </li>
                        </template>
                    </ul>
                </div>
            </aside>
        </div>
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            <slot></slot>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Exam, Question } from '@/types';
import { Link } from '@inertiajs/vue3';

defineProps<{
    exam?: Exam,
    question?: Question
}>()
</script>