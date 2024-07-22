<template>
    <Card>
        <template #header>
            <div class="grid grid-cols-12 justify-between items-center">
                <div class="col-span-8">
                    <h1 class="text-lg">{{ section.title }}</h1>
                    <Description :description="section.description" />
                    
                </div>
                <div class="col-span-4 flex justify-end">
                    <Button @click.prevent="editSection = !editSection">
                        <Icon name="PencilIcon" class="w-4 h-4"></Icon>
                    </Button>
                </div>
            </div>
        </template>

        <SectionForm :section="section" :course="course" v-if="editSection"/>

        {{ section  }}
    </Card>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Course, Section } from "@/types";
import Card from "@/Components/Card.vue";
import Icon from "@/Components/Icon.vue";
import Button from "@/Components/Button.vue";
import SectionForm from './SectionForm.vue';
import Description from '../Description.vue';

const props = defineProps<{
    course: Course;
    section: Section;
}>();

const editSection = ref(false)
</script>
