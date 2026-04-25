<template>
    <AdminLayout>
        <div id="users">
            <Card class="mb-5">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-lg">Topics</h1>
                        <Breadcrumb :items="breadcrumb" />
                    </div>
                    <div>
                        <Button is="a" :href="route('admin.topics.create')">Create Topic </Button>
                    </div>
                </div>
            </Card>

            <Card>
                <!-- Search bar -->
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex-1 relative sm:max-w-xs">
                        <MagnifyingGlassIcon class="absolute left-2.5 top-1/2 -translate-y-1/2 h-3.5 w-3.5 text-indigo-400 dark:text-indigo-300 pointer-events-none" />
                        <input
                            type="text"
                            :value="filters.search"
                            @input="onSearch"
                            placeholder="Search topics…"
                            class="w-full pl-8 pr-3 py-1.5 text-xs bg-white dark:bg-gray-800 dark:text-gray-100 border border-indigo-200 dark:border-indigo-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-gray-400 dark:placeholder-gray-500"
                        />
                    </div>
                    <button
                        v-if="filters.search"
                        type="button"
                        @click="clearSearch"
                        class="inline-flex items-center gap-1 text-xs font-medium text-indigo-600 dark:text-indigo-300 hover:text-white hover:bg-indigo-600 dark:hover:bg-indigo-500 bg-white dark:bg-gray-800 border border-indigo-300 dark:border-indigo-600 rounded-lg px-3 py-1.5 transition-colors shadow-sm"
                    >
                        <XMarkIcon class="h-3 w-3" />
                        Clear
                    </button>
                </div>

                <!-- Bulk action bar -->
                <transition
                    enter-active-class="transition ease-out duration-200"
                    enter-from-class="opacity-0 -translate-y-2"
                    enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="transition ease-in duration-150"
                    leave-from-class="opacity-100 translate-y-0"
                    leave-to-class="opacity-0 -translate-y-2"
                >
                    <div v-if="selected.length" class="flex items-center gap-3 mb-4 px-4 py-2.5 bg-indigo-600 dark:bg-indigo-700 rounded-xl">
                        <span class="text-xs font-semibold text-white">
                            {{ selected.length }} topic{{ selected.length > 1 ? 's' : '' }} selected
                        </span>
                        <div class="flex items-center gap-2 ml-auto">
                            <button
                                type="button"
                                @click="bulkDelete"
                                class="inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded-lg transition-colors shadow-sm"
                            >
                                <TrashIcon class="h-3.5 w-3.5" />
                                Delete
                            </button>
                            <button
                                type="button"
                                @click="selected = []"
                                class="p-1.5 rounded-lg text-indigo-200 hover:text-white hover:bg-indigo-500 transition-colors"
                                title="Clear selection"
                            >
                                <XMarkIcon class="h-4 w-4" />
                            </button>
                        </div>
                    </div>
                </transition>

                <DataTable
                    v-model="selected"
                    :rows="response.data"
                    :columns="columns"
                >
                    <template #actions-data="{ row }">
                        <div class="flex justify-end">
                            <Link
                                :href="route('admin.topics.edit', row)"
                                
                            >
                                <PencilIcon class="mr-2 h-6 w-6"></PencilIcon>
                            </Link>
                            <Link
                                @click="deleteTopic(row)"
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
    MagnifyingGlassIcon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";

import CircleSvg from "@/Components/CircleSvg.vue";
import { LinkType, JsonResponse, Topic } from "@/types";
import { PropType, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import DataTable from "@/Components/Datatable/Table.vue";
import Checkbox from "@/Components/Form/Checkbox.vue";
import Modal from "@/Components/Modal.vue";
import Card from "@/Components/Card.vue";
import Pagination from "@/Components/Pagination.vue";
import Select from "@/Components/Form/Select.vue";
import Button from "@/Components/Button.vue";

export default {
    name: "Topics",
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
        MagnifyingGlassIcon,
        XMarkIcon,
        Modal,
        Card,
        Pagination,
        Select,
        Button
    },
    props: {
        response: {
            type: Object as PropType<JsonResponse<Topic[]>>,
            required: true,
        },
        filters: {
            type: Object as PropType<{ search?: string }>,
            default: () => ({}),
        },
    },
    setup(props) {

        const selected = ref([]);

        const columns = [
            { key: "title", label: "Title" },
            { key: "courses_count", label: "Courses" },
            { key: "exams_count", label: "Exams" },
            { key: "actions" },
        ];

        let searchTimer: ReturnType<typeof setTimeout>;
        function onSearch(e: Event) {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                applyFilters({ s: (e.target as HTMLInputElement).value });
            }, 350);
        }
        function clearSearch() {
            applyFilters({ s: '' });
        }
        function applyFilters(params: Record<string, string>) {
            router.get(route('admin.topics.index'), params, {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            });
        }

        function deleteTopic(topic: Topic) {
            if (confirm("Are you sure you want to delete this item?")) {
                router.delete(route("admin.topics.destroy", topic.id));
            }
        }

        function bulkDelete() {
            if (!selected.value.length) return;
            if (confirm(`Are you sure you want to delete ${selected.value.length} topic(s)?`)) {
                router.post(route('admin.topics.bulk-delete'), { ids: selected.value.map((t: Topic) => t.id) }, {
                    onSuccess: () => { selected.value = []; },
                });
            }
        }

        return {
            columns,
            selected,
            deleteTopic,
            bulkDelete,
            onSearch,
            clearSearch,
        };
    },
    computed: {
        breadcrumb(): LinkType[] {
            return [
                {
                    name: "Topics",
                    href: route("admin.topics.index"),
                    current: route().current("admin.topics.index"),
                },
            ];
        },
    },
};
</script>
