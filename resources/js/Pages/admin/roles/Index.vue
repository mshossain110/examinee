<template>
    <AdminLayout>
        <div id="users">
            <Card class="mb-5">
                <div class="flex justify-between items-center">
                    <div>
                        <h1>Roles</h1>
                        <Breadcrumb :items="breadcrumb" />
                    </div>
                    <div>
                        <Button is="a" :href="route('admin.roles.create')">Create Role </Button>
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
                                :href="route('admin.roles.edit', row)"
                                v-if="canModify(row.name)"
                            >
                                <PencilIcon class="mr-2 h-6 w-6"></PencilIcon>
                            </Link>
                            <Link
                                @click="deleteRole(row)"
                                as="button"
                                href=""
                                v-if="canModify(row.name)"
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
import { LinkType, JsonResponse, Role } from "@/types";
import { PropType } from "vue";
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
    name: "Roles",
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
            type: Object as PropType<JsonResponse<Role[]>>,
            required: true,
        },
        app_roles: {
            type: Array,
        },
    },
    setup(props) {
        const columns = [
            {
                key: "name",
                label: "Name",
            },
            {
                key: "permissions.0.name",
                label: "permissions",
            },
            {
                key: "actions",
            },
        ];

        function canModify(name: string): boolean {
            return !Array.from(props.app_roles).includes(name);
        }

        function deleteRole(role: Role) {
            if (confirm("Are you sure you want to delete this item?")) {
                router.delete(route("admin.roles.destroy", role.id));
            }
        }

        return {
            columns,
            canModify,
            deleteRole,
        };
    },
    data() {
        return {
            confirmingUserDeletion: false,
            selected: [],
            pagination: {},
            perPage: 10,
            dataReady: false,
            showCreateUserForm: false,
            userEditing: null,
            creatingNewUser: false,
            userFormKey: 432489,
            availableRoles: [],
            rolesDataReady: false,
            lockJigled: false,
        };
    },
    computed: {
        breadcrumb(): LinkType[] {
            return [
                {
                    name: "Roles",
                    href: route("admin.roles.index"),
                    current: route().current("admin.roles.index"),
                },
            ];
        },
    },
};
</script>
