<template>
    <Card>
        <DataTable :rows="questions" :columns="columns">
            <template #actions-data="{ row }">
                <div class="flex justify-end">
                    <Link :href="route('admin.exams.edit', row)">
                        <Icon class="mr-2 h-6 w-6" name="PencilIcon"></Icon>
                    </Link>
                    <Link @click="deleteExam(row)" as="button" href="">
                        <Icon
                            class="mr-2 h-6 w-6 text-red-500"
                            name="TrashIcon"
                        ></Icon>
                    </Link>
                </div>
            </template>
        </DataTable>
    </Card>
</template>

<script setup lang="ts">
import Card from "@/Components/Card.vue";
import DataTable from "@/Components/Datatable/Table.vue";
import Icon from "@/Components/Icon.vue";
import { Exam, Question } from "@/types";

defineProps<{
    questions: Question[];
}>();

const columns = [
    {
        key: "qtype",
        label: "Type",
    },
    {
        key: "question",
        label: "Question",
    },
    {
        key: "mark",
        label: "Mark",
    },
    {
        key: "nmark",
        label: "Nagative mark",
    },
    {
        key: "actions",
    },
];
</script>
