<template>
    <div class="single-exam exam">
        <section
            v-if="startTime"
            class="exam-bord"
        >
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>REASONING : QUESTION 1 OF 16</h4>
                    <div class="time">
                        <strong>Rmaining Time: {{ parseInt(examRemainingTime/60) }}: {{ parseInt(examRemainingTime%60) }}</strong>
                        <strong>Total Time : {{ exam.duration }}</strong>
                    </div>
                </div>
                <Question
                    v-for="question in questions"
                    v-show="showQuestionNumber === question.id"
                    :key="question.id"
                    :question="question"
                />

                <div class="card-body">
                    <div class="row mt-5">
                        <div class="col">
                            <div class="next-button">
                                <button
                                    type="button"
                                    class="btn btn-outline-success"
                                >
                                    Preview
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-outline-dark"
                                >
                                    Mark For Review
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-outline-success"
                                >
                                    Next
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-outline-dark"
                                >
                                    Clear Ans
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-outline-danger"
                                >
                                    Finish
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mt-5">
                        <div class="col-12">
                            <div>
                                <h5>QUESTIONS</h5>
                            </div>
                        </div>
                        <div class="col-12">
                            <div
                                class="btn-toolbar"
                                role="toolbar"
                                aria-label="Toolbar with button groups"
                            >
                                <button
                                    v-for="(question, i ) in questions"
                                    :key="question.id"
                                    type="button"
                                    class="btn btn-primary mr-1"
                                    @click.prevent="showQuestionNumber = question.id"
                                >
                                    {{ i + 1 }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="details">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="list-group list-group-horizontal-lg">
                                <a class="list-group-item">
                                    Overview
                                </a>
                                <a class="list-group-item">
                                    Author
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-5">
                            <div class="overview">
                                <h5 class="text-uppercase">
                                    ABOUT THIS EXAM
                                </h5>
                                <strong>{{ exam.title }}</strong>

                                <ul class="list-unstyled mt-3">
                                    <li><strong>Total Time</strong> {{ exam.duration }}</li>
                                    <li><strong>Number of Questions</strong> {{ exam.number_of_questions }}</li>
                                    <li><strong>Pass Mark</strong> {{ exam.pass_mark }}</li>
                                    <li><strong>Difficulty</strong> {{ exam.difficulty }}</li>
                                    <li><strong>Cirtificate</strong> {{ exam.certification }}</li>
                                </ul>

                                <h5 class="text-uppercase mt-3">
                                    Details
                                </h5>

                                <div>{{ exam.description }}</div>

                                <a
                                    href="#"
                                    class="btn btn-primary mt-5"
                                    @click.prevent="start"
                                >Start Exam</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
import Question from './Question.vue'
export default {
    components: {
        Question
    },
    data: () => ({
        loading: false,
        startTime: null,
        exam: {},
        questions: [],
        examRemainingTime: null,
        showQuestionNumber: null
    }),
    computed: {
        isExamRunning () {
            return this.startTime
        }
    },
    watch: {
        '$route' () {
            this.getExam()
        },
        startTime () {
            this.remainingTime()
        }
    },
    created () {
        this.getExam()
    },
    mounted () {

    },
    methods: {
        getExam () {
            if (this.loading) {
                return
            }
            this.loading = true

            const params = {
                id: this.$route.params.exam
            }

            axios.get(`/api/take-exam/${params.id}`, { params })
                .then(res => {
                    this.exam = res.data.data.exam
                    this.startTime = res.data.data.time

                    this.loading = false
                    if (this.startTime) {
                        this.start()
                    }
                })
        },
        start () {
            if (this.loading) {
                return
            }
            this.loading = true

            const params = {
                id: this.$route.params.exam
            }

            axios.get(`/api/start-exam/${params.id}`, { params })
                .then(res => {
                    this.questions = res.data.data.questions
                    this.startTime = res.data.data.time
                    this.showQuestionNumber = res.data.data.questions[0].id
                    this.loading = false
                })
        },
        remainingTime () {
            this.examRemainingTime = moment.utc().diff(moment.utc(this.startTime).add(this.exam.duration, 'minutes'), 'seconds')
            this.examRemainingTime = Math.abs(this.examRemainingTime)

            if (this.examRemainingTime / 60 > this.exam.duration) {
                return
            }

            setTimeout(() => {
                this.remainingTime()
            }, 1000)
        }
    }
}
</script>
