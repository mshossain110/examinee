<script setup lang="ts">
import { Course } from '@/types'
const props = defineProps<{
    course: Course
}>()

</script>

<template>
    <div class="bg-gray-800 rounded-lg shadow-lg p-6 transform hover:scale-105 transition duration-300">
        <div class="mb-8">
            <h3 class="text-2xl font-semibold text-white">
                Pro
            </h3>
            <p class="mt-4 text-gray-400">
                Ideal for growing businesses and enterprises.
            </p>
        </div>
        <div class="mb-8">
            <span class="text-5xl font-extrabold text-white">${{ course.price }}</span>
        </div>
        <h3 class="text-2xl text-white">
            This course includes:
        </h3>
        <ul class="mb-8 space-y-4 text-gray-400">
            <li class="flex items-center">
                <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>9.5 hours on-demand video</span>
            </li>
            <li class="flex items-center">
                <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>95 downloadable resources</span>
            </li>
            <li class="flex items-center">
                <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Access on mobile and TV</span>
            </li>
            <li class="flex items-center">
                <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Full lifetime access</span>
            </li>
            <li class="flex items-center">
                <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Certificate of completion</span>
            </li>
        </ul>
        <button
            class="block w-full py-3 px-6 text-center rounded-md text-white font-medium bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600"
            type="button" @click.prevent="startLearning" v-if="user">
            Start Learning
        </button>
    </div>
</template>