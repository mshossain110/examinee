<template>
    <AdminLayout>
        <CourseLayout :course="course">
            <CourseForm :course="course"/>
        </CourseLayout>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CourseForm from '@/Elements/course/CourseForm.vue'
import CourseLayout from '@/Elements/course/CourseLayout.vue'
import { Course } from "@/types";

defineProps<{
    course?: Course
}>()
</script>
