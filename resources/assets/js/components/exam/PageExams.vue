<template>
    <div class="page">
        <div class="card border-0">
            <div class="card-body d-flex justify-content-between">
                <div class="w-25">
                    <div class="input-group mb-3">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Search"
                        >
                        <div class="input-group-append">
                            <span
                                id="basic-addon2"
                                class="input-group-text"
                            >Search</span>
                        </div>
                    </div>
                </div>
                <div class="w-25 text-right">
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click.prevent="newExam = !newExam"
                    >
                        Create Exam
                    </button>
                </div>
            </div>
            <div
                v-if="newExam"
                class="card-body"
            >
                <NewExam @save="saveExam" />
            </div>
        </div>

        <Exams
            v-if="exams.length"
            :exams="exams"
        />
    </div>
</template>

<script>
import NewExam from './NewExam'
import Exams from './Exams'
export default {
    components: {
        NewExam,
        Exams
    },
    data () {
        return {
            exams: [],
            newExam: false
        }
    },
    computed: {

    },
    created () {
        this.getExams()
    },
    methods: {
        getExams () {
            const params = {
                course_id: this.$route.params.id
            }
            axios.get('/api/exams', { params: params })
                .then(res => {
                    this.exams = res.data.data
                })
        },
        saveExam (exam) {
            this.exams.unshift(exam)
            this.newExam = false
        }
    }
}
</script>
