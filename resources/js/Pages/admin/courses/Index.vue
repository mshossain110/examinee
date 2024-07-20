<template>
    <AdminLayout>
        <div id="users">
            <Card class="mb-5">
                <div class="flex justify-between items-center">
                    <div>
                        <h1>Courses</h1>
                        <Breadcrumb :items="breadcrumb" />
                    </div>
                    <div>
                        <Button is="a" :href="route('admin.courses.create')">Create Course </Button>
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
                        <div class="flex">
                            <Link
                                :href="route('admin.courses.edit', row)"
                            >
                                <PencilIcon class="mr-2 h-6 w-6"></PencilIcon>
                            </Link>
                            <Link
                                @click="deleteCourse(row)"
                                as="button"
                                href=""
                            >
                                <TrashIcon class="mr-2 h-6 w-6"></TrashIcon>
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
import { LinkType, JsonResponse, Course } from "@/types";
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
    name: "Courses",
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
            type: Object as PropType<JsonResponse<Course[]>>,
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
                key: "price",
                label: "Price",
            },
            {
                key: "start_date",
                label: "Started at",
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

        function deleteCourse(Course: Course) {
            if (confirm("Are you sure you want to delete this item?")) {
                router.delete(route("admin.Courses.destroy", Course.id));
            }
        }

        return {
            selected,
            columns,
            deleteCourse,
        };
    },
    computed: {
        breadcrumb(): LinkType[] {
            return [
                {
                    name: "Courses",
                    href: route("admin.courses.index"),
                    current: route().current("admin.courses.index"),
                },
            ];
        },
    },
};
</script>
