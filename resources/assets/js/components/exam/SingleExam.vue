<template>
    <div

        class="card "
    >
        <div class="card-header align-items-center">
            <div class="card-text d-flex   justify-content-between">
                <h3>{{ exam.title }}</h3>
                <div class="card-action">
                    <a
                        href="#"
                        class="btn btn-primary btn-sm"
                        @click.prevent="newQuestionForm = !newQuestionForm"
                    > New Question</a>

                    <a
                        href="#"
                        @click.prevent="editExam = !editExam"
                    ><i class="fas fa-edit" /></a>

                    <a
                        href="#"
                        class="text-danger"
                        @click.prevent="deleteExam"
                    ><i class="fas fa-trash-alt" /></a>
                </div>
            </div>
            <div>
                {{ exam.description }}
            </div>
        </div>
        <div
            v-if="editExam"
            class="card-body"
        >
            <NewExam
                :exam="exam"
                @edit-exam="editExam = false"
            />
        </div>
        <div
            v-if="newQuestionForm"
            class="card-body"
        >
            <NewQuestion
                :exam="exam"
                @store="newQuestionFrom"
            />
        </div>
        <div class="card-body p-0">
            <template v-if="exam.questions.length">
                <SingleQuestion
                    v-for="question in exam.questions"
                    :key="question.id"
                    :question="question"
                />
            </template>
        </div>
    </div>
</template>

<script>
import SingleQuestion from './SingleQuestion'
import NewQuestion from './NewQuestion'
import NewExam from './NewExam'

export default {
    components: {
        SingleQuestion,
        NewQuestion,
        NewExam
    },
    props: {
        exam: {
            type: Object,
            required: true
        }
    },
    data () {
        return {
            newQuestionForm: false,
            questionInfo: false,
            questionSetting: false,
            editExam: false
        }
    },
    computed: {

    },
    created () {

    },
    methods: {
        deleteExam () {
            const con = confirm('Do You Want To Delete Exam?')

            if (!con) {
                return
            }
            axios.delete(`/api/exams/${this.exam.id}`)
                .then(res => {})
        },
        newQuestionFrom (question) {
            this.exam.questions.push(question)
            this.newQuestionForm = false
        }

    }
}
</script>
