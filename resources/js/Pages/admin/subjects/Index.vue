<template>
    <AdminLayout>
        <div id="users">
            <Card class="mb-5">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-lg">Subjects</h1>
                        <Breadcrumb :items="breadcrumb" />
                    </div>
                    <div>
                        <Button is="a" :href="route('admin.subjects.create')">Create Subject </Button>
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
                                :href="route('admin.subjects.edit', row)"
                                
                            >
                                <PencilIcon class="mr-2 h-6 w-6"></PencilIcon>
                            </Link>
                            <Link
                                @click="deleteSubject(row)"
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
    TrashIcon,
    PencilIcon,
} from "@heroicons/vue/24/outline";

import CircleSvg from "@/Components/CircleSvg.vue";
import { LinkType, JsonResponse, Subject } from "@/types";
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
    name: "Subjects",
    components: {
        AdminLayout,
        Breadcrumb,
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
            type: Object as PropType<JsonResponse<Subject[]>>,
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
                key: "courses_count",
                label: "Courses",
            },
            {
                key: "exams_count",
                label: "Exms",
            },
            {
                key: "actions",
            },
        ];


        function deleteSubject(topic: Subject) {
            if (confirm("Are you sure you want to delete this item?")) {
                router.delete(route("admin.subjects.destroy", topic.id));
            }
        }

        return {
            columns,
            selected,
            deleteSubject,
        };
    },
    computed: {
        breadcrumb(): LinkType[] {
            return [
                {
                    name: "Subjects",
                    href: route("admin.subjects.index"),
                    current: route().current("admin.subjects.index"),
                },
            ];
        },
    },
};
</script>
