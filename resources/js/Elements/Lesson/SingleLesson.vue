<template>
    <div class="single-lesson">
        <section v-if="lesson.type == 'Video'" class="video">
            <VideoPreview :file="lesson.object" />
        </section>

        <section class="details mt-8">
                <Tabs :items="items" class="w-full">
                    <template #overview>
                        <Card>
                            <h3 class="text-uppercase">ABOUT THIS Lesson</h3>
                            <strong>{{ lesson.title }}</strong>
                            <p>{{ lesson.short_text }}</p>

                            <h3 class="text-uppercase">Details</h3>

                            <div>{{ lesson.full_text }}</div>
                        </Card>
                    </template>
                </Tabs>
        </section>
    </div>
</template>

<script setup lang="ts">
import Tabs from '@/Components/Tabs.vue'
import Card from '@/Components/Card.vue';
import { Lesson } from '@/types';
// import VideoPreview from './../../common/dropzone/VideoPreview'

defineProps<{
    lesson: Lesson
}>()

const items = [
    {
        slot: "overview",
        label: "Overview",
    },
    {
        slot: "descussions",
        label: "Descussions",
    },
    {
        slot: "author",
        label: "Author",
    },
];

</script>
