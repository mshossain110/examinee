<script setup lang="ts">
import { Subject } from "@/types";
import { Head, Link } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";

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
                        <div class="w-full max-w-sm mx-auto rounded-md shadow-md overflow-hidden" >
                            <div class="flex items-end justify-end h-56 w-full bg-cover" style="background-image: url('https://picsum.photos/750/80')">
                                <button class="p-2 rounded-full bg-blue-600 text-white mx-5 -mb-4 hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </button>
                            </div>
                            <div class="px-5 py-1">
                                <h3 class="text-gray-700">{{course.title}}</h3>
                            </div>
                            <div class="px-5 pb-2 flex justify-between items-center">
                                <span class="text-gray-700 mt-2">${{course.price}}</span>
                                <Link
                                    
                                    :href="course.permalink"
                                    class="middle none center mr-2 rounded-lg bg-blue-500 py-1 px-2 font-sans text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                >
                                    view
                                </Link>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </MainLayout>
    
</div>
</template>
