<template>
    <div
        v-if="!loading"
        class="single-exam exam"
    >
        <section
            v-if="startTime"
            class="exam-bord"
        >
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>REASONING : QUESTION 1 OF 16</h4>
                    <div
                        v-if="startTime"
                        class="time d-flex flex-column"
                    >
                        <strong>Rmaining Time: {{ parseInt(examRemainingTime/60) }}: {{ parseInt(examRemainingTime%60) }}</strong>
                        <strong>Total Time : {{ exam.duration }}</strong>
                    </div>
                </div>
                <Question
                    v-for="question in questions"
                    v-show="showQuestionNumber === question.id"
                    :key="question.id"
                    :question="question"
                    :answers="answers"
                    @previous="previousQuestion"
                    @next="nextQuestion"
                    @finish="finishExam"
                />

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
                                    :class="{'answered': hasAnswer(question.id), 'active': showQuestionNumber === question.id}"
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
                                <table class="table table-bordered mt-4">
                                    <tbody>
                                        <tr>
                                            <th scope="row">
                                                Total Time
                                            </th>
                                            <td>{{ exam.duration }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                Number of Questions
                                            </th>
                                            <td>{{ exam.number_of_questions }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                Pass Mark
                                            </th>
                                            <td>
                                                {{ exam.pass_mark }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                Difficulty Level
                                            </th>
                                            <td>
                                                {{ exam.difficulty }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                                Cirtificate
                                            </th>
                                            <td>
                                                {{ exam.certification }}
                                            </td>
                                        </tr>
                                        <tr v-if="exam.meta">
                                            <th scope="row">
                                                Retake After
                                            </th>
                                            <td>
                                                {{ exam.meta.retake }} Days
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div
                                    v-if="result"
                                    class="card border-0"
                                >
                                    <div class="card-header border-0">
                                        <h4>Result</h4>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-bordered mt-4">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">
                                                        Obtain Mark
                                                    </th>
                                                    <td>
                                                        {{ result.obtain_mark }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        Pass Mark
                                                    </th>
                                                    <td>
                                                        {{ result.is_pass }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        Time Taken
                                                    </th>
                                                    <td>
                                                        {{ result.time_taken }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        Exam Date
                                                    </th>
                                                    <td>
                                                        {{ fromNow(result.created_at ) }}
                                                    </td>
                                                </tr>
                                                <tr v-if="timeToHeldExam>0">
                                                    <th scope="row">
                                                        Retry After
                                                    </th>
                                                    <td>
                                                        {{ timeToHeldExam }} Days
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="question-button">
                                            <a
                                                v-if="questions.length"
                                                href="#"
                                                class="btn btn-primary"
                                                @click.prevent="showAnswerdQuestion = !showAnswerdQuestion"
                                            >Show Question</a>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="text-uppercase mt-3">
                                    Details
                                </h5>

                                <div>{{ exam.description }}</div>

                                <a
                                    v-if="canStartExam"
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
        showQuestionNumber: null,
        answers: [],
        result: null,
        showAnswerdQuestion: false
    }),
    computed: {
        isExamRunning () {
            return this.startTime
        },

        canStartExam () {
            if (!this.examRetakeRemainingDays) {
                return true
            }
            if (this.exam.meta && parseInt(this.exam.meta.retake) < this.examRetakeRemainingDays) {
                return true
            }
            return false
        },
        examRetakeRemainingDays () {
            return this.result && moment.utc().diff(moment.utc(this.result.created_at), 'days', true)
        },
        timeToHeldExam () {
            return Math.ceil(this.exam.meta && parseInt(this.exam.meta.retake) - this.examRetakeRemainingDays)
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
                    this.exam = res.data.exam
                    this.startTime = res.data.time
                    this.result = res.data.result
                    this.questions = res.data.questions

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

            axios.post(`/api/start-exam/${params.id}`, { params })
                .then(res => {
                    this.questions = res.data.questions
                    this.startTime = res.data.time
                    this.showQuestionNumber = res.data.questions[0].id
                    this.answers = res.data.answers
                })
                .finally(() => {
                    this.loading = false
                })
        },
        remainingTime () {
            this.examRemainingTime = moment.utc(this.startTime).add(this.exam.duration, 'minutes').diff(moment.utc(), 'seconds')
            if (this.examRemainingTime / 60 <= 0) {
                this.complete()
                return
            }

            setTimeout(() => {
                this.remainingTime()
            }, 1000)
        },
        storeAnswer (ans) {
            return new Promise((resolve, reject) => {
                axios.post(`/api/answer/${this.exam.id}`, ans)
                    .then(res => {
                        resolve(res.data)
                    })
                    .catch((error) => {
                        reject(error)
                    })
            })
        },
        nextQuestion (ans) {
            this.storeAnswer(ans)
                .then(res => {
                    this.answers = res.answers
                    const i = this.questions.findIndex(q => this.showQuestionNumber === q.id)
                    if (i + 1 === this.questions.length) {
                        this.showQuestionNumber = this.questions[0].id
                    } else {
                        this.showQuestionNumber = this.questions[i + 1].id
                    }
                })
        },
        previousQuestion (ans) {
            this.storeAnswer(ans)
                .then(res => {
                    this.answers = res.answers
                    const i = this.questions.findIndex(q => this.showQuestionNumber === q.id)
                    if (i === 0) {
                        this.showQuestionNumber = this.questions[this.questions.length - 1].id
                    } else {
                        this.showQuestionNumber = this.questions[i - 1].id
                    }
                })
        },
        finishExam (ans) {
            this.storeAnswer(ans)
                .then(res => {
                    this.complete()
                })
        },
        complete () {
            axios.post(`/api/complete-exam/${this.exam.id}`)
                .then(res => {
                    this.result = res.data.result
                    this.startTime = null
                    window.location.reload()
                })
        },
        hasAnswer (id) {
            const answer = this.answers.find(a => a.id === id)
            return answer && typeof answer.answer !== 'undefined'
        }
    }
}
</script>
