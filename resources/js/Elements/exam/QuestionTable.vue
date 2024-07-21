<template>
    <div id="question-lists">
        <Card class="mb-5">
            <div class="flex justify-between items-center">
                <div>
                    <h1>Questions</h1>
                    <Breadcrumb :items="breadcrumb" />
                </div>
                <div>
                    <Button is="a" :href="route('admin.questions.create', exam.id)">
                        Create Question
                    </Button>
                </div>
            </div>
        </Card>
        <Card>
            <DataTable :rows="questions" :columns="columns">
                <template #actions-data="{ row }">
                    <div class="flex justify-end">
                        <Link
                            :href="route('admin.questions.edit', [exam.id, row.id])"
                        >
                            <Icon
                                class="mr-2 h-6 w-6 text-gray-300"
                                name="PencilIcon"
                            ></Icon>
                        </Link>
                        <Link @click="deleteQuestion(row)" as="button" href="">
                            <Icon
                                class="mr-2 h-6 w-6 text-red-500"
                                name="TrashIcon"
                            ></Icon>
                        </Link>
                    </div>
                </template>
            </DataTable>
        </Card>
    </div>
</template>

<script setup lang="ts">
import { Link, router } from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import DataTable from "@/Components/Datatable/Table.vue";
import Icon from "@/Components/Icon.vue";
import { Exam, Question, LinkType } from "@/types";
import Button from "@/Components/Button.vue";

const props = defineProps<{
    exam: Exam;
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

const breadcrumb: LinkType[] = [
                {
                    name: "Exams",
                    href: route("admin.exams.index"),
                    current: route().current("admin.exams.index"),
                },
                {
                    name: "Questions",
                    href: route("admin.questions.index", [props.exam.id]),
                    current: route().current("admin.questions.*"),
                },
            ];
    
function deleteQuestion(question: Question) {
    if (confirm("Are you sure you want to delete this item?")) {
        router.delete(route("admin.questions.destroy", [props.exam.id, question.id]));
    }
}
</script>
