<template>
    <div class="exams">
        <div
            v-for="exam in exams"
            :key="exam.id"
            class="exam-lists mt-2"
        >
            <SingleExam :exam="exam" />
        </div>
    </div>
</template>

<script>
import SingleExam from './SingleExam'

export default {
    components: {
        SingleExam
    },
    props: {
        exams: {
            type: Array,
            required: true
        }
    },
    data () {
        return {

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
