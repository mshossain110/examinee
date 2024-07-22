<template>
    <Card>
        <template #header v-if="!section">
            <h1 class="text-lg">{{ section?.id ? "Update Section" : "Create Section" }}</h1>
        </template>
        <form @submit.prevent="submit">
            <div class="grid grid-cols-1  gap-4 mb-2">
                <Label label="Title" name="title">
                    <Input v-model="form.title" />
                </Label>
            </div>
            <div class="grid grid-cols-1 gap-4 mb-2">
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
            <Button type="submit">
                {{ props.section?.id ? "Update Section" : "Create Section" }}
            </Button>
        </form>
    </Card>
</template>

<script setup lang="ts">
import Label from "@/Components/Form/Label.vue";
import Input from "@/Components/Form/Input.vue";
import { Course, Section } from "@/types";
import { useForm } from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import Button from "@/Components/Button.vue";

const props = defineProps<{
    course: Course
    section?: Section
}>()

const form = useForm({
    title: props.section.title,
    description: props.section.description,
});

function submit() {
    if ( props.section) {
        form.put(route("admin.sections.update", [props.course.id, props.section.id]));
    } else {
        form.put(route("admin.sections.store", [props.course.id]));
    }
}
</script>
