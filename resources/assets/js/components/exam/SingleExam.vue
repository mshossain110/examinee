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
                        class="btn btn-primary  btn-sm"
                        @click.prevent="editExam = !editExam"
                    ><i class="fas fa-edit" /></a>

                    <a
                        href="#"
                        class="btn btn-primary  btn-sm"
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
            <NewQuestion :exam="exam" />
        </div>
        <div class="card-body">
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

    }
}
</script>
