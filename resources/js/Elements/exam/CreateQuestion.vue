<template>
    <Card>
        <template #header>
            <h1>{{ question?.id ? "Update Question" : "Create Question" }}</h1>
        </template>
        <form @submit.prevent="submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                <Label label="Question type" name="qtype">
                    <Select
                        :options="[
                            { label: 'Objective', value: 'Objective' },
                            { label: 'True/False', value: 'TrueFalse' },
                        ]"
                        v-model="form.qtype"
                    ></Select>
                </Label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-2">
                <Label label="Question" name="question">
                    <textarea
                        v-model="form.question"
                        name="question"
                        cols="80"
                        rows="8"
                        class="relative block w-full disabled:cursor-not-allowed disabled:opacity-75 focus:outline-none border-0 form-input rounded-md placeholder-gray-400 dark:placeholder-gray-500 text-md px-3 py-2 shadow-sm bg-transparent text-gray-900 dark:text-white ring-1 ring-inset ring-blue-500 dark:ring-blue-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                    ></textarea>
                </Label>
            </div>
            <div class="grid grid-cols-12 gap-y-2 gap-x-2 mb-2">
                <strong class="text-md col-span-1">Correct Answer</strong>
                <strong class="text-md col-span-10">Option</strong>
                <strong class="text-md col-span-1"></strong>
                <template v-for="(op, index) in questionOptions" :key="'qoi-'+ index">
                    <Checkbox
                        v-model="questionOptions[index].answer"
                        label=""
                        class="col-span-1"
                    />
                    <textarea
                        v-model="questionOptions[index].option"
                        name="question"
                        cols="40"
                        rows="8"
                        class="relative col-span-10 block w-full disabled:cursor-not-allowed disabled:opacity-75 focus:outline-none border-0 form-input rounded-md placeholder-gray-400 dark:placeholder-gray-500 text-md px-3 py-2 shadow-sm bg-transparent text-gray-900 dark:text-white ring-1 ring-inset ring-blue-500 dark:ring-blue-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                    ></textarea>
                    <Button class="col-span-1 justify-center h-10" @click.prevent="removeOption(index)" color="red">Remove</Button>
                </template>
                
            </div>
            <div class="grid grid-cols-1 mb-2 w-40">
                <Button class="justify-center" @click.prevent="addMoreOption" color="gray">Add More Option</Button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                <Label label="Mark" name="mark">
                    <Input
                        v-model="form.mark"
                        type="number"
                    />
                </Label>
                <Label label="Nagative Mark" name="nmark">
                    <Input
                        v-model="form.nmark"
                        type="number"
                    />
                </Label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-2">
                <Label label="hint" name="hint">
                    <textarea
                        v-model="form.hint"
                        name="hint"
                        cols="80"
                        rows="8"
                        class="relative block w-full disabled:cursor-not-allowed disabled:opacity-75 focus:outline-none border-0 form-input rounded-md placeholder-gray-400 dark:placeholder-gray-500 text-md px-3 py-2 shadow-sm bg-transparent text-gray-900 dark:text-white ring-1 ring-inset ring-blue-500 dark:ring-blue-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                    ></textarea>
                </Label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-2">
                <Label label="Answer Explanation" name="explanation">
                    <textarea
                        v-model="form.explanation"
                        name="hint"
                        cols="80"
                        rows="8"
                        class="relative block w-full disabled:cursor-not-allowed disabled:opacity-75 focus:outline-none border-0 form-input rounded-md placeholder-gray-400 dark:placeholder-gray-500 text-md px-3 py-2 shadow-sm bg-transparent text-gray-900 dark:text-white ring-1 ring-inset ring-blue-500 dark:ring-blue-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                    ></textarea>
                </Label>
            </div>
            <Button>
                {{ props.question?.id ? "Update Question" : "Create Question" }}
            </Button>
        </form>
    </Card>
</template>

<script setup lang="ts">
import { ref, onBeforeMount } from 'vue';
import { useForm } from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import { Exam, Question, QuestionOption } from '@/types'
import Button from "@/Components/Button.vue";
import Label from "@/Components/Form/Label.vue";
import Input from "@/Components/Form/Input.vue";
import Checkbox from "@/Components/Form/Checkbox.vue";
import Select from "@/Components/Form/Select.vue";
import { useId } from '@/Composables/utils';

const props = defineProps<{
    exam: Exam,
    question?: Question
}>()

const form = useForm({
    qtype: props.question?.qtype,
    question: props.question?.question,
    options: props.question?.options,
    answers: props.question?.answers,
    hint: props.question?.hint,
    mark: props.question?.mark,
    nmark: props.question?.nmark,
    explanation: props.question?.explanation
})

const questionOptions = ref<QuestionOption[]>([]);

function submit() {
    form.answers = [];
    form.options = [];
    questionOptions.value.map(qo => {
        if (qo.answer) {
            form.answers.push(qo.id)
        }
        delete qo.answer;
        form.options.push(qo)
    })

    if (props.question?.id) {
        form.put(route("admin.questions.update", [props.exam.id, props.question.id]));
    } else {
        form.post(route("admin.questions.store", props.exam.id));
    }
}

onBeforeMount(() => {
    if (props.question?.options.length) {
        props.question.options.map(qo => {
            console.log(props.question.answers.indexOf(qo.id))
            questionOptions.value.push({
                option: qo.option,
                answer: props.question.answers.indexOf(qo.id) !== -1,
                id: qo.id
            })
        })
    } else {
        addMoreOption()
    }
})

function addMoreOption () {
    questionOptions.value.push({ answer: false, option: '', id: useId('qo', 10) })
}

function removeOption (index: number) {
    questionOptions.value.splice(index, 1)
}

</script>