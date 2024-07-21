<template>
    <AdminLayout>
        <ExamLayout :exam="exam">
            <CreateQuestion :exam="exam" :question="question"></CreateQuestion>
        </ExamLayout>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CreateExam from '@/Elements/exam/CreateExam.vue'
import ExamLayout from '@/Elements/exam/ExamLayout.vue'
import CreateQuestion from '@/Elements/exam/CreateQuestion.vue'
import { Exam, Question } from "@/types";

defineProps<{
    exam: Exam,
    question?: Question
}>()
</script>
