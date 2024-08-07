<template>
    <Card>
        <template #header>
            <h1>{{ props.course?.id ? "Update Course" : "Create Course" }}</h1>
        </template>
        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 gap-4 mb-2">
                <Label label="Title" name="title" size="lg">
                    <Input v-model="form.title" size="lg" />
                </Label>
                <Label label="Slug" name="slug" size="lg">
                    <Input v-model="form.slug" :readonly="editslug" size="lg" >
                        <template #trailing>
                            <a href="" @click.prevent="editslug = !editslug" class="inline-block p-3 bg-gray-500">
                                <Icon v-if="editslug" name="EyeSlashIcon" class="w-6 h-6 " />
                                <Icon v-else name="EyeIcon" class="w-6 h-6 " />
                            </a>
                        </template>
                    </Input>
                    
                </Label>
                <Label label="Subtitle" name="subtitle" size="lg">
                    <Input v-model="form.subtitle" size="lg" />
                </Label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-2">
                <Label label="Description" name="description">
                    <textarea
                        v-model="form.description"
                        name="description"
                        cols="80"
                        rows="8"
                        class="relative block w-full disabled:cursor-not-allowed disabled:opacity-75 focus:outline-none border-0 form-input rounded-md placeholder-gray-400 dark:placeholder-gray-500 text-md px-3 py-2 shadow-sm bg-transparent text-gray-900 dark:text-white ring-1 ring-inset ring-blue-500 dark:ring-blue-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                    ></textarea>
                </Label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-2">
                <Label label="Requirements" name="requirements">
                    <textarea
                        v-model="form.requirements"
                        name="requirements"
                        cols="80"
                        rows="8"
                        class="relative block w-full disabled:cursor-not-allowed disabled:opacity-75 focus:outline-none border-0 form-input rounded-md placeholder-gray-400 dark:placeholder-gray-500 text-md px-3 py-2 shadow-sm bg-transparent text-gray-900 dark:text-white ring-1 ring-inset ring-blue-500 dark:ring-blue-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                    ></textarea>
                </Label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-2">
                <Label label="Features" name="features">
                    <textarea
                        v-model="form.features"
                        name="features"
                        cols="80"
                        rows="8"
                        class="relative block w-full disabled:cursor-not-allowed disabled:opacity-75 focus:outline-none border-0 form-input rounded-md placeholder-gray-400 dark:placeholder-gray-500 text-md px-3 py-2 shadow-sm bg-transparent text-gray-900 dark:text-white ring-1 ring-inset ring-blue-500 dark:ring-blue-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                    ></textarea>
                </Label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                <Label label="Status" name="status">
                    <Select
                        :options="[
                            { label: 'Published', value: 1 },
                            { label: 'Pending', value: 2 },
                        ]"
                        v-model="form.status"
                    ></Select>
                </Label>
                <Label
                    label="Price"
                    name="price"
                >
                    <Input v-model="form.price" type="number" />
                </Label>
                <Label
                    label="Discount"
                    name="discount"
                    help="Discount will be calculate in %"
                >
                    <Input v-model="form.discount" type="number" step=".2" />
                </Label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-2">
                <Checkbox v-model="form.certified" label="Certified" />
            </div>
            <Button>
                {{ props.course?.id ? "Update Course" : "Create Course" }}
            </Button>
        </form>
    </Card>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from "@inertiajs/vue3";
import { Course } from "@/types";
import Card from "@/Components/Card.vue";
import Button from "@/Components/Button.vue";
import Label from "@/Components/Form/Label.vue";
import Input from "@/Components/Form/Input.vue";
import Checkbox from "@/Components/Form/Checkbox.vue";
import Select from "@/Components/Form/Select.vue";
import Icon from '@/Components/Icon.vue'

const props = defineProps<{
    course?: Course;
}>();

const form = useForm({
    title: props.course?.title,
    subtitle: props.course?.subtitle,
    slug: props.course?.slug,
    description: props.course?.description,
    requirements: props.course?.requirements,
    status: props.course?.status,
    thumbnail: props.course?.thumbnail,
    start_date: props.course?.start_date,
    features: props.course?.features,
    certified: props.course?.certified,
    price: props.course?.price,
    discount: props.course?.discount,
});

const editslug = ref(false);

function submit() {
    if (props.course.id) {
        form.put(route("admin.courses.update", props.course.id));
    } else {
        form.post(route("admin.courses.store"));
    }
}
</script>
