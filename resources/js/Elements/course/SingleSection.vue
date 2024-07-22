<template>
    <Card class="mb-4">
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

        <SectionForm :section="section" :course="course" v-if="editSection" />

        <ul class="grid grid-cols-1 space-y-2">
            <template v-for="lesson in section.lessons" :key="'lesson-' + lesson.id">
                <Lesson :lesson="lesson" />
            </template>
            <template v-for="exam in section.exams" :key="'exam-' + exam.id">
                <Exam :exam="exam" />
            </template>
        </ul>

        <template #footer>
            <div class="flex justify-center items-center space-x-4 mb-4">
                <Button @click.prevent="lessonForm = !lessonForm; examForm = false; ">Create Lesson</Button>
                <Button @click.prevent="examForm = !examForm; lessonForm = false; ">Create Exam</Button>
            </div>
            <div class="flex w-full">
                <LessonForm v-if="lessonForm && !examForm"/>
                <CreateExam v-if="examForm && !lessonForm"/>
            </div>
        </template>
    </Card>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { Course, Section } from "@/types";
import Card from "@/Components/Card.vue";
import Icon from "@/Components/Icon.vue";
import Button from "@/Components/Button.vue";
import SectionForm from "./SectionForm.vue";
import Description from "../Description.vue";
import Lesson from "./Lesson.vue";
import Exam from "./Exam.vue";
import LessonForm from "@/Elements/course/LessonForm.vue";
import CreateExam from "@/Elements/exam/CreateExam.vue";

const props = defineProps<{
    course: Course;
    section: Section;
}>();

const editSection = ref(false);
const lessonForm = ref(false);
const examForm = ref(false);

</script>
