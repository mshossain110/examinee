<template>
    <AdminLayout>
        <div id="subjects">
            <Card class="mb-5">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-lg">Subjects</h1>
                        <Breadcrumb :items="breadcrumb" />
                    </div>
                    <div>
                        <Button is="a" :href="route('admin.subjects.create')">Create Subject</Button>
                    </div>
                </div>
            </Card>

            <Card>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700 text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                <th class="py-3 px-4 w-full">Title</th>
                                <th class="py-3 px-4 whitespace-nowrap">Courses</th>
                                <th class="py-3 px-4 whitespace-nowrap">Exams</th>
                                <th class="py-3 px-4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="subject in response.data" :key="subject.id">
                                <!-- ── Parent row ─────────────────────────────── -->
                                <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <!-- Expand/collapse toggle -->
                                            <button
                                                v-if="subject.children?.length"
                                                type="button"
                                                @click="toggle(subject.id)"
                                                class="flex-shrink-0 p-0.5 rounded text-gray-400 hover:text-indigo-600 transition-colors"
                                            >
                                                <ChevronDownIcon v-if="expanded.has(subject.id)" class="h-4 w-4" />
                                                <ChevronRightIcon v-else class="h-4 w-4" />
                                            </button>
                                            <!-- Spacer when no children so title aligns -->
                                            <span v-else class="w-5 flex-shrink-0" />

                                            <!-- Image or heroicon -->
                                            <img v-if="subject.image_url" :src="subject.image_url" :alt="subject.title"
                                                class="h-9 w-9 rounded-lg object-cover flex-shrink-0 ring-1 ring-gray-200 dark:ring-gray-700" />
                                            <span v-else-if="subject.icon && allIcons[subject.icon]"
                                                class="h-9 w-9 flex items-center justify-center rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex-shrink-0">
                                                <component :is="allIcons[subject.icon]" class="h-5 w-5 text-indigo-600 dark:text-indigo-400" />
                                            </span>
                                            <span v-else class="h-9 w-9 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 flex-shrink-0 text-base">📚</span>

                                            <div>
                                                <span class="font-semibold text-gray-900 dark:text-white">{{ subject.title }}</span>
                                                <span v-if="subject.children?.length" class="ml-2 text-xs text-gray-400">{{ subject.children.length }} sub-subjects</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                                            {{ subject.courses_count ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300">
                                            {{ subject.exams_count ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center justify-end gap-1">
                                            <Link :href="route('admin.subjects.edit', subject)" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                <PencilIcon class="h-5 w-5 text-gray-500 hover:text-indigo-600" />
                                            </Link>
                                            <button type="button" @click="deleteSubject(subject)" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                <TrashIcon class="h-5 w-5 text-gray-500 hover:text-red-600" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- ── Child rows (collapsible) ───────────────── -->
                                <template v-if="expanded.has(subject.id)">
                                    <tr v-for="child in subject.children" :key="child.id"
                                        class="border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/20 hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10 transition-colors">
                                        <td class="py-2.5 px-4">
                                            <div class="flex items-center gap-2 pl-7">
                                                <!-- curved sub-line indicator -->
                                                <span class="text-gray-300 dark:text-gray-600 flex-shrink-0">&#8627;</span>

                                                <img v-if="child.image_url" :src="child.image_url" :alt="child.title"
                                                    class="h-7 w-7 rounded-md object-cover flex-shrink-0 ring-1 ring-gray-200 dark:ring-gray-700" />
                                                <span v-else-if="child.icon && allIcons[child.icon]"
                                                    class="h-7 w-7 flex items-center justify-center rounded-md bg-indigo-50 dark:bg-indigo-900/30 flex-shrink-0">
                                                    <component :is="allIcons[child.icon]" class="h-4 w-4 text-indigo-500 dark:text-indigo-400" />
                                                </span>
                                                <span v-else class="h-7 w-7 flex items-center justify-center rounded-md bg-gray-100 dark:bg-gray-800 flex-shrink-0 text-xs">📚</span>

                                                <span class="text-gray-700 dark:text-gray-300">{{ child.title }}</span>
                                            </div>
                                        </td>
                                        <td class="py-2.5 px-4">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                                                {{ child.courses_count ?? 0 }}
                                            </span>
                                        </td>
                                        <td class="py-2.5 px-4">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300">
                                                {{ child.exams_count ?? 0 }}
                                            </span>
                                        </td>
                                        <td class="py-2.5 px-4">
                                            <div class="flex items-center justify-end gap-1">
                                                <Link :href="route('admin.subjects.edit', child)" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                    <PencilIcon class="h-4 w-4 text-gray-400 hover:text-indigo-600" />
                                                </Link>
                                                <button type="button" @click="deleteSubject(child)" class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                    <TrashIcon class="h-4 w-4 text-gray-400 hover:text-red-600" />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </template>

                            <tr v-if="!response.data.length">
                                <td colspan="4" class="py-12 text-center text-sm text-gray-400">No subjects found.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :paginate="response.meta" class="justify-end mt-4" />
            </Card>
        </div>
    </AdminLayout>
</template>

<script lang="ts" setup>
import { ref, computed } from 'vue';
import {
    TrashIcon, PencilIcon, ChevronRightIcon, ChevronDownIcon,
} from '@heroicons/vue/24/outline';
import * as OutlineIcons from '@heroicons/vue/24/outline';
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import Card from '@/Components/Card.vue';
import Pagination from '@/Components/Pagination.vue';
import Button from '@/Components/Button.vue';
import { LinkType, JsonResponse, Subject } from '@/types';

const props = defineProps<{ response: JsonResponse<Subject[]> }>();

const allIcons = OutlineIcons as Record<string, any>;

// ── Expand / collapse ────────────────────────────────────────
const expanded = ref<Set<number>>(new Set());
function toggle(id: number) {
    if (expanded.value.has(id)) {
        expanded.value.delete(id);
    } else {
        expanded.value.add(id);
    }
    // trigger reactivity
    expanded.value = new Set(expanded.value);
}

// ── Actions ──────────────────────────────────────────────────
function deleteSubject(subject: Subject) {
    if (confirm('Are you sure you want to delete this subject?')) {
        router.delete(route('admin.subjects.destroy', subject.id));
    }
}

// ── Breadcrumb ───────────────────────────────────────────────
const breadcrumb = computed<LinkType[]>(() => [
    { name: 'Subjects', href: route('admin.subjects.index'), current: route().current('admin.subjects.index') },
]);
</script>

