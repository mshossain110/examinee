<template>
    <div

        class="card "
    >
        <div class="card-header align-items-center">
            <div class="card-text d-flex   justify-content-between">
                <h5>{{ exam.title }}</h5>
                <div class="e-action">
                    <a
                        href="#"
                        class="btn btn-primary btn-sm"
                        @click.prevent="newQuestionForm = !newQuestionForm"
                    > New Question</a>

                    <a
                        href="#"
                        class="ea-icon"
                        @click.prevent="editExam = !editExam"
                    ><i class="fas fa-edit" /></a>

                    <a
                        href="#"
                        class=" ea-icon text-danger"
                        @click.prevent="deleteExam"
                    ><i class="fas fa-trash-alt" /></a>
                </div>
            </div>
            <div
                class="description"
                style="font-size:13px;"
            >
                <p class="m-0">
                    {{ exam.description }}
                </p>
            </div>
        </div>
        <div
            v-if="editExam"
            class="card-body"
        >
            <NewExam
                :exam="exam"
                @update="editExam = false"
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
                    @deleteQuestion="deleteQuestion"
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
        },
        deleteQuestion (question) {
            var i = this.exam.questions.findIndex(q => q.id === question.id)
            if (i !== -1) {
                this.exam.questions.splice(i, 1)
            }
        }

    }
}
</script>
