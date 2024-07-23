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
                                :href="
                                    course?.id
                                        ? route('admin.courses.edit', course.id)
                                        : route('admin.courses.create')
                                "
                                class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                                :class="[
                                    {
                                        'bg-gray-300': route().current(
                                            'admin.courses.*',
                                            course?.id
                                        ),
                                    },
                                ]"
                            >
                                <span class="ml-3">{{
                                    course?.id ? "Edit" : "Create"
                                }}</span>
                            </a>
                        </li>
                        <template v-if="course?.id">
                            <li>
                                <Link
                                    :href="
                                        route('admin.sections.index', course.id)
                                    "
                                    class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                                    :class="[
                                        {
                                            'bg-gray-300': route().current(
                                                'admin.sections.*',
                                                course.id
                                            ),
                                        },
                                    ]"
                                >
                                    <span class="flex-1 ml-3 whitespace-nowrap">
                                        Sections
                                    </span>
                                </Link>
                                <Link
                                    :href="
                                        route('admin.course-student', course.id)
                                    "
                                    class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700"
                                    :class="[
                                        {
                                            'bg-gray-300': route().current(
                                                'admin.course-student',
                                                course.id
                                            ),
                                        },
                                    ]"
                                >
                                    <span class="flex-1 ml-3 whitespace-nowrap">
                                        Student
                                    </span>
                                </Link>
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
import { Course } from "@/types";
import { Link } from "@inertiajs/vue3";

defineProps<{
    course?: Course;
}>();
</script>
