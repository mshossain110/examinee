<template>
    <AdminLayout>
        <ExamLayout :exam="exam">
            <CreateExam :exam="exam" />
        </ExamLayout>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CreateExam from '@/Elements/exam/CreateExam.vue'
import ExamLayout from '@/Elements/exam/ExamLayout.vue'
import { Exam } from "@/types";

defineProps<{
    exam: Exam
}>()
</script>
