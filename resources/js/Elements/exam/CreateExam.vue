<template>
    <Card>
        <template #header>
            <h1>{{ props.exam?.id ? "Update Exam" : "Create Exam" }}</h1>
        </template>
        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                <Label label="Title" name="title">
                    <Input v-model="form.title" />
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                <Label label="Status" name="status">
                    <Select
                        :options="[
                            { label: 'Free', value: 1 },
                            { label: 'Course', value: 2 },
                            { label: 'Course &amp; Paid', value: 3 },
                            { label: 'Paid', value: 4 },
                        ]"
                        v-model="form.status"
                    ></Select>
                </Label>
                <Label
                    label="Price"
                    name="price"
                    v-if="form.status == 3 || form.status == 4"
                >
                    <Input v-model="form.price" type="number" step="1" />
                </Label>
                <Label label="Duration" name="duration">
                    <Input
                        v-model="form.duration"
                        type="number"
                        min="10"
                        max="120"
                        step="1"
                    />
                </Label>
                <Label label="Pass mark" name="pass_mark">
                    <Input v-model="form.pass_mark" type="number" />
                </Label>
                <Label label="Difficulty" name="difficulty">
                    <Input
                        v-model="form.difficulty"
                        type="number"
                        min="1"
                        max="4"
                    />
                </Label>
                <Label label="Number of questions" name="number_of_questions">
                    <Input v-model="form.number_of_questions" type="number" />
                </Label>
                <Label
                    label="Retake After"
                    name="number_of_questions"
                    :hint="`Examinee can retake the exam after ${form.meta.retake} days`"
                >
                    <Input v-model="form.meta.retake" type="number" />
                </Label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-2">
                <Checkbox v-model="form.certification" label="Certification" />
                <Checkbox
                    v-model="form.random_questions"
                    label="Random question"
                />
                <Checkbox v-model="form.meta.show_hint" label="Show hint" />
                <Checkbox
                    v-model="form.meta.show_question"
                    label="Show Question"
                />
                <Checkbox
                    v-model="form.meta.show_explanation"
                    label="Show Explanation"
                />
                <Checkbox
                    v-model="form.meta.negative_mark"
                    label="Negative Mark"
                />
                <Checkbox v-model="form.meta.show_answer" label="Show Answer" />
            </div>
            <Button>
                {{ props.exam?.id ? "Update Exam" : "Create Exam" }}
            </Button>
        </form>
    </Card>
</template>

<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { Exam } from "@/types";
import Card from "@/Components/Card.vue";
import Button from "@/Components/Button.vue";
import Label from "@/Components/Form/Label.vue";
import Input from "@/Components/Form/Input.vue";
import Checkbox from "@/Components/Form/Checkbox.vue";
import Select from "@/Components/Form/Select.vue";

const props = defineProps<{
    exam?: Exam;
}>();

const form = useForm({
    title: props.exam?.title,
    description: props.exam?.description,
    status: props.exam?.status,
    price: props.exam?.price,
    duration: props.exam?.duration,
    pass_mark: props.exam?.pass_mark,
    number_of_questions: props.exam?.number_of_questions,
    random_questions: props.exam?.random_questions,
    certification: props.exam?.certification,
    difficulty: props.exam?.difficulty,
    meta: {
        retake: props.exam?.meta?.retake,
        show_hint: props.exam?.meta?.show_hint,
        show_question: props.exam?.meta?.show_question,
        show_explanation: props.exam?.meta?.show_explanation,
        negative_mark: props.exam?.meta?.negative_mark,
        show_answer: props.exam?.meta?.show_answer,
    },
});

function submit() {
    if (props.exam.id) {
        form.put(route("admin.exams.update", props.exam.id));
    } else {
        form.post(route("admin.exams.store"));
    }
}
</script>
