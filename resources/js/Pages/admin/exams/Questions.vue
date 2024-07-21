<template>
    <AdminLayout>
        <ExamLayout :exam="exam">
            <QuestionTable :questions="questions"/>
        </ExamLayout>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CreateExam from '@/Elements/exam/CreateExam.vue'
import ExamLayout from '@/Elements/exam/ExamLayout.vue'
import QuestionTable from '@/Elements/exam/QuestionTable.vue'
import { Exam, Question } from "@/types";

defineProps<{
    exam: Exam,
    questions: Question[]
}>()
</script>
