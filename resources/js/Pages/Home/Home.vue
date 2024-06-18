<script setup lang="ts">
import { Subject } from "@/types";
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import Course from "@/Elements/Course.vue";

defineProps<{
  subjects: Subject[]
}>();

</script>

<template>
<div>
    <Head title="Users" />
    <MainLayout>
        <template v-for="subject in subjects" :key="subject.id">
            <div class="container mx-auto px-6 mb-8" >
                <div class=" w-full border-b-2 mb-2">
                    <h3 class="text-gray-500 text-2xl font-medium">{{subject.title}}</h3>
                    <span class="mt-3 text-sm text-gray-500">{{subject.description}}</span>
                </div>
                
                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6">
                    <template v-for="course in subject.courses" :key="course.id">
                        <Course :course="course" />
                    </template>
                </div>
            </div>
        </template>
    </MainLayout>
    
</div>
</template>
