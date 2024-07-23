<template>
    <AdminLayout>
        <CourseLayout :course="course">
            <Card>
                <div v-for="student in students" :key="student.id" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 mb-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" :src="student.avatar" alt="" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="#" class="focus:outline-none">
                        <span class="absolute inset-0" aria-hidden="true" />
                        <p class="text-sm font-medium text-gray-900">
                            {{ student.full_name }}
                        </p>
                        <p class="text-sm text-gray-500 truncate">
                            {{ student.progress }}
                        </p>
                        </a>
                    </div>
                    </div>
            </Card>

        </CourseLayout>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CourseLayout from '@/Elements/course/CourseLayout.vue';
import SingleSection from '@/Elements/course/SingleSection.vue'
import { Course, Student } from "@/types";

defineProps<{
    course: Course,
    students: Student[]
}>()
</script>
