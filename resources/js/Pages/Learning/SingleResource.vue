<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Course, Exam, Lesson } from "@/types";
import Card from "@/Components/Card.vue";
import SingleLesson from "@/Elements/Lesson/SingleLesson.vue";

defineProps<{
    course: Course;
    resource: Lesson | Exam;
}>();
</script>

<template>
    <MainLayout>
        <Head :title="resource.title" />
        <div class="grid grid-cols-12">
            <div class="col-span-3">
                <Card class="my-5">
                    <template #header>
                        <h2>Course content</h2>
                    </template>

                    <template
                        v-for="section in course.sections"
                        :key="`section${section.id}`"
                    >
                        <h2 class="text-lg font-bold">{{ section.title }}</h2>
                        <ul>
                            <template v-for="resource in section.resources">
                                <li>
                                    {{ resource.title }}
                                </li>
                            </template>
                        </ul>
                    </template>
                </Card>
            </div>

            <div class="col-span-9">
                <SingleLesson :lesson="resource as Lesson" />
            </div>
        </div>
    </MainLayout>
</template>
