<script setup lang="ts">
import { ref } from 'vue'
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Course } from "@/types";
import CourseComponent from "@/Elements/Course.vue";
import Card from "@/Components/Card.vue";
import Button from "@/Components/Button.vue";

defineProps<{
    courses: Course[];
    canModify: boolean
}>();

const openCourseForm = ref(false);
</script>

<template>
    <MainLayout>
        <Head title="Instructor course" />
        <div class="container mx-auto">
            <Card class="my-5">
                <div class="flex justify-between items-center">
                    <h1>Instruct courses</h1>
                    <Button v-if="canModify" @click.prevent="openCourseForm = true">Create course</Button>
                </div>
            </Card>
            <div
                class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6"
            >
                <template v-for="course in courses" :key="course.id">
                    <CourseComponent :course="course" :canModify="canModify"/>
                </template>
            </div>
        </div>
    </MainLayout>
</template>
