<template>
    <div

        class="card "
    >
        <div class="card-header">
            {{ exam.title }}
            <p class="card-text">
                {{ exam.description }}
            </p>
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
export default {
    components: {
        SingleQuestion
    },
    props: {
        exam: {
            type: Object,
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
