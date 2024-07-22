<template>
        <Card>
        <template #header>
            <h1>{{ lesson?.id ? "Update Lesson" : "Create Lesson" }}</h1>
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
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-2">
                <Label label="Short text" name="short_text">
                    <textarea
                        v-model="form.short_text"
                        name="short_text"
                        cols="80"
                        rows="8"
                        class="relative block w-full disabled:cursor-not-allowed disabled:opacity-75 focus:outline-none border-0 form-input rounded-md placeholder-gray-400 dark:placeholder-gray-500 text-md px-3 py-2 shadow-sm bg-transparent text-gray-900 dark:text-white ring-1 ring-inset ring-blue-500 dark:ring-blue-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                    ></textarea>
                </Label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-2">
                <Label label="Full text" name="full_text" help="This will be a full tutorial">
                    <textarea
                        v-model="form.full_text"
                        name="full_text"
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
                            { label: 'Free', value: 1 },
                            { label: 'Subscriber', value: 2 },
                            { label: 'Paid', value: 3 },
                        ]"
                        v-model="form.status"
                    ></Select>
                </Label>
                <Label label="Lesson Type" name="type">
                    <Select
                        :options="[
                            { label: 'Text', value: 1 },
                            { label: 'Vedio', value: 2 },
                            { label: 'Audio', value: 3 },
                            { label: 'PDF', value: 4 },
                        ]"
                        v-model="form.type"
                    ></Select>
                </Label>
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
import { Course, Lesson } from "@/types";
import Card from "@/Components/Card.vue";
import Button from "@/Components/Button.vue";
import Label from "@/Components/Form/Label.vue";
import Input from "@/Components/Form/Input.vue";
import Checkbox from "@/Components/Form/Checkbox.vue";
import Select from "@/Components/Form/Select.vue";
import Icon from '@/Components/Icon.vue'


const props = defineProps<{
    course: Course;
    lesson?: Lesson
}>();

const form = useForm({
    title: props.lesson?.title,
    slug: props.lesson?.slug,
    short_text: props.lesson?.short_text,
    full_text: props.lesson?.full_text,
    type: props.lesson?.slug,
    object: props.lesson?.slug,
    status: props.lesson?.slug,
});

const editslug = ref(false);

function submit() {
    if (props.lesson?.id) {
        form.put(route("admin.lessons.update", [props.course.id, props.lesson?.id]));
    } else {
        form.post(route("admin.lessons.store", props.course.id));
    }
}
</script>