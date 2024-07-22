<template>
    <AdminLayout>
        <CourseLayout :course="course">
                <SingleSection  v-for="section in sections" :key="section.id" :section="section" :course="course"/>
        </CourseLayout>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CourseLayout from '@/Elements/course/CourseLayout.vue';
import SingleSection from '@/Elements/course/SingleSection.vue'
import { Course, Section } from "@/types";

defineProps<{
    course: Course,
    sections: Section[]
}>()
</script>
