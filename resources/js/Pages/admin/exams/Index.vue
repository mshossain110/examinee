<template>
    <AdminLayout>
        <div id="users">
            <Card class="mb-5">
                <div class="flex justify-between items-center">
                    <div>
                        <h1>Exams</h1>
                        <Breadcrumb :items="breadcrumb" />
                    </div>
                    <div>
                        <Button is="a" :href="route('admin.exams.create')">Create Exam </Button>
                    </div>
                </div>
            </Card>

            <Card>
                <DataTable
                    v-model="selected"
                    :rows="response.data"
                    :columns="columns"
                >
                    <template #actions-data="{ row }">
                        <div class="flex justify-end">
                            <Link
                                :href="route('admin.exams.edit', row)"
                            >
                                <PencilIcon class="mr-2 h-6 w-6"></PencilIcon>
                            </Link>
                            <Link
                                @click="deleteExam(row)"
                                as="button"
                                href=""
                            >
                                <TrashIcon class="mr-2 h-6 w-6 text-red-500"></TrashIcon>
                            </Link>
                        </div>
                    </template>
                </DataTable>
                <Pagination :paginate="response.meta" class="justify-end" />
            </Card>
        </div>
    </AdminLayout>
</template>

<script lang="ts">
import {
    ChevronRightIcon,
    TrashIcon,
    PencilIcon,
} from "@heroicons/vue/24/outline";

import CircleSvg from "@/Components/CircleSvg.vue";
import { LinkType, JsonResponse, Exam } from "@/types";
import { PropType, ref } from "vue";
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import DataTable from "@/Components/Datatable/Table.vue";
import Checkbox from "@/Components/Form/Checkbox.vue";
import Modal from "@/Components/Modal.vue";
import Card from "@/Components/Card.vue";
import { router } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import Select from "@/Components/Form/Select.vue";
import Button from "@/Components/Button.vue";

export default {
    name: "Exams",
    components: {
        AdminLayout,
        Breadcrumb,
        ChevronRightIcon,
        CircleSvg,
        Link,
        DataTable,
        Checkbox,
        TrashIcon,
        PencilIcon,
        Modal,
        Card,
        Pagination,
        Select,
        Button
    },
    props: {
        response: {
            type: Object as PropType<JsonResponse<Exam[]>>,
            required: true,
        }
    },
    setup(props) {
        const selected = ref([]);
        const columns = [
            {
                key: "title",
                label: "Title",
            },
            {
                key: "duration",
                label: "Duration",
            },
            {
                key: "pass_mark",
                label: "Pass mark",
            },
            {
                key: "number_of_questions",
                label: "Questions",
            },
            {
                key: "difficulty",
                label: "Difficulty",
            },
            {
                key: "certification",
                label: "Certification",
            },
            {
                key: "status",
                label: "Status",
            },
            {
                key: "created_by",
                label: "Creator",
            },
            {
                key: "actions",
            },
        ];

        function deleteExam(exam: Exam) {
            if (confirm("Are you sure you want to delete this item?")) {
                router.delete(route("admin.exams.destroy", exam.id));
            }
        }

        return {
            selected,
            columns,
            deleteExam,
        };
    },
    computed: {
        breadcrumb(): LinkType[] {
            return [
                {
                    name: "Exams",
                    href: route("admin.exams.index"),
                    current: route().current("admin.exams.index"),
                },
            ];
        },
    },
};
</script>
