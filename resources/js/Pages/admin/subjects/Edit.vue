<template>
    <AdminLayout>
        <div id="edit-subject">
            <!-- Flash toast -->
            <transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0 translate-y-2"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 translate-y-2"
            >
                <div v-if="toast.show" :class="[
                    'fixed bottom-6 right-6 z-50 flex items-start gap-3 px-4 py-3 rounded-xl shadow-xl text-sm font-medium max-w-sm',
                    toast.type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'
                ]">
                    <CheckCircleIcon v-if="toast.type === 'success'" class="h-5 w-5 flex-shrink-0 mt-0.5" />
                    <ExclamationCircleIcon v-else class="h-5 w-5 flex-shrink-0 mt-0.5" />
                    <span class="flex-1">{{ toast.message }}</span>
                    <button type="button" @click="toast.show = false" class="ml-1 opacity-75 hover:opacity-100">
                        <XMarkIcon class="h-4 w-4" />
                    </button>
                </div>
            </transition>
            <Card class="mb-5">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-lg">Edit Subject</h1>
                        <Breadcrumb :items="breadcrumb" />
                    </div>
                    <div>
                        <Link :href="route('admin.subjects.index')" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors">
                            <ArrowLeftIcon class="h-4 w-4" />
                            Back to Subjects
                        </Link>
                    </div>
                </div>
            </Card>

            <Card>
                <template #header>
                    <h1>Edit Subject</h1>
                </template>
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left: main fields (2/3) -->
                        <div class="lg:col-span-2 space-y-4">
                            <Label label="Title" name="title">
                                <Input v-model="form.title" />
                                <p v-if="form.errors.title" class="text-xs text-red-500 mt-1">{{ form.errors.title }}</p>
                            </Label>

                            <!-- Parent subject -->
                            <div v-if="!(form.parent === 0 && (props.subject.children_count ?? 0) > 0)">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Parent Subject <span class="text-gray-400 font-normal">(optional)</span></label>
                                <select
                                    v-model="form.parent"
                                    class="relative block w-full focus:outline-none border-0 form-input rounded-md text-md px-3 py-2 shadow-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-white ring-1 ring-inset ring-blue-500 dark:ring-blue-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                                >
                                    <option :value="0">— None (top-level subject) —</option>
                                    <option v-for="p in parentSubjects" :key="p.id" :value="p.id">{{ p.title }}</option>
                                </select>
                            </div>
                            <div v-else class="flex items-start gap-2 rounded-lg border border-indigo-200 dark:border-indigo-700 bg-indigo-50 dark:bg-indigo-900/20 px-4 py-3 text-sm text-indigo-700 dark:text-indigo-300">
                                <InformationCircleIcon class="h-5 w-5 flex-shrink-0 mt-0.5" />
                                <span>This is a top-level subject with <strong>{{ props.subject.children_count }}</strong> child subject{{ (props.subject.children_count ?? 0) !== 1 ? 's' : '' }}. Parent assignment is not available.</span>
                            </div>

                            <Label label="Description" name="description">
                                <textarea
                                    v-model="form.description"
                                    name="description"
                                    rows="5"
                                    class="relative block w-full focus:outline-none border-0 form-input rounded-md placeholder-gray-400 dark:placeholder-gray-500 text-md px-3 py-2 shadow-sm bg-transparent text-gray-900 dark:text-white ring-1 ring-inset ring-blue-500 dark:ring-blue-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                                />
                            </Label>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Icon</label>
                                <HeroiconPicker v-model="form.icon" />
                                <div v-if="form.icon" class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                                    <component :is="iconComponent" class="h-5 w-5 text-indigo-500" />
                                    <span>{{ form.icon.replace('Icon', '') }}</span>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Used on the home page if no image is set.</p>
                            </div>
                        </div>

                        <!-- Right: image upload sidebar (1/3) -->
                        <div class="flex flex-col gap-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cover Image</label>
                            <div
                                class="flex flex-col items-center justify-center gap-3 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 p-6 cursor-pointer hover:border-indigo-400 transition-colors flex-1 min-h-[180px]"
                                @click="imageInput?.click()"
                            >
                                <img v-if="imagePreview" :src="imagePreview" alt="Preview" class="w-full rounded-lg object-cover max-h-48" />
                                <template v-else>
                                    <PhotoIcon class="h-12 w-12 text-gray-300 dark:text-gray-600" />
                                    <div class="text-center">
                                        <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">Click to upload</p>
                                        <p class="text-xs text-gray-400 mt-0.5">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                </template>
                                <input
                                    ref="imageInput"
                                    type="file"
                                    accept="image/*"
                                    class="hidden"
                                    @change="onImageChange"
                                />
                            </div>
                            <p v-if="form.errors.image" class="text-xs text-red-500">{{ form.errors.image }}</p>
                            <button v-if="imagePreview" type="button" @click="clearImage"
                                class="text-xs text-red-500 hover:underline text-left">Remove image</button>
                        </div>
                    </div>

                    <div class="mt-6">
                        <Button :disabled="form.processing">
                            {{ form.processing ? 'Saving…' : 'Update Subject' }}
                        </Button>
                    </div>
                </form>
            </Card>
        </div>
    </AdminLayout>
</template>

<script lang="ts" setup>
import { ref, computed, watch, PropType } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Label from '@/Components/Form/Label.vue';
import Input from '@/Components/Form/Input.vue';
import Card from '@/Components/Card.vue';
import Button from '@/Components/Button.vue';
import Breadcrumb from '@/Components/Breadcrumb.vue';
import HeroiconPicker from '@/Components/Form/HeroiconPicker.vue';
import { Subject, LinkType } from '@/types';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { PhotoIcon, CheckCircleIcon, ExclamationCircleIcon, XMarkIcon, InformationCircleIcon, ArrowLeftIcon } from '@heroicons/vue/24/outline';
import * as OutlineIcons from '@heroicons/vue/24/outline';

const page = usePage();

// ── Toast ────────────────────────────────────────────────────
const toast = ref<{ show: boolean; type: 'success' | 'error'; message: string }>({
    show: false, type: 'success', message: '',
});
let toastTimer: ReturnType<typeof setTimeout>;
watch(
    () => (page.props as any).flash,
    (flash: any) => {
        if (flash?.success) {
            toast.value = { show: true, type: 'success', message: flash.success };
        } else if (flash?.error) {
            toast.value = { show: true, type: 'error', message: flash.error };
        } else { return; }
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => { toast.value.show = false; }, 4000);
    },
    { deep: true, immediate: true }
);

const props = defineProps({
    subject: {
        type: Object as PropType<Subject>,
        required: true,
    },
    parentSubjects: {
        type: Array as PropType<{ id: number; title: string }[]>,
        default: () => [],
    },
});

const imageInput = ref<HTMLInputElement | null>(null);
const imagePreview = ref<string | null>(props.subject.image_url ?? null);

const form = useForm({
    _method: 'PUT',
    title: props.subject.title,
    description: props.subject.description ?? '',
    icon: props.subject.icon ?? '',
    parent: props.subject.parent ?? 0,
    image: null as File | null,
});

const allIcons = OutlineIcons as Record<string, any>;
const iconComponent = computed(() => form.icon ? allIcons[form.icon] ?? null : null);

function onImageChange(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (!file) return;
    form.image = file;
    imagePreview.value = URL.createObjectURL(file);
}

function clearImage() {
    form.image = null;
    imagePreview.value = null;
    if (imageInput.value) imageInput.value.value = '';
}

function submit() {
    form.post(route('admin.subjects.update', props.subject.id), {
        forceFormData: true,
    });
}

const breadcrumb = computed<LinkType[]>(() => [
    { name: 'Subjects', href: route('admin.subjects.index'), current: false },
    { name: props.subject.title, href: route('admin.subjects.edit', props.subject.id), current: true },
]);
</script>

