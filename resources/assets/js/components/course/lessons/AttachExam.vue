<template>
    <form @submit.prevent="submit">
        <label class="typo__label">Select Exam</label>
        <Multiselect
            v-model="exam"
            track-by="id"
            label="title"
            placeholder="Select Exam"
            :options="exams"
            :searchable="false"
            :allow-empty="false"
        />
        <div class="d-block">
            <button type="submit">
                Attach Exam
            </button>
        </div>
    </form>
</template>

<script>
import Multiselect from 'vue-multiselect'

export default {
    components: {
        Multiselect
    },
    props: {
        session: {
            type: Object,
            required: true
        }

    },
    data () {
        return {
            exam: null,
            exams: []
        }
    },
    created () {
        this.getExams()
    },
    methods: {
        submit () {
            const params = {
                exam_id: this.exam.id,
                session_id: this.session.id

            }
            axios.put(`/api/sessions/${this.session.id}/attach-exam`, params)
                .then(res => {
                    this.$emit('attach', res.data)
                })
        },

        getExams () {
            const params = {

            }
            axios.get('/api/exams', { params: params })
                .then(res => {
                    this.exams = res.data.data
                })
        }
    }
}
</script>
