<template>
    <div
        class="card question-list mt-1 border-0"
    >
        <div class="card-header d-flex justify-content-between">
            <div>
                {{ question.question }}
            </div>
            <div class="q-action">
                <a
                    href="#"
                    @click.prevent="editQuestionForm = !editQuestionForm"
                ><i class="fas fa-edit" /></a>

                <a
                    href="#"
                    class="text-danger"
                    @click.prevent="deleteQuestion"
                ><i class="fas fa-trash-alt" /></a>
            </div>
        </div>
        <div
            v-if="editQuestionForm"
            class="card-body"
        >
            <NewQuestion
                :question="question"
                @update="editQuestionForm=false"
            />
        </div>
    </div>
</template>

<script>
import NewQuestion from './NewQuestion'
export default {
    components: {
        NewQuestion
    },
    props: {
        question: {
            type: Object,
            required: true
        }
    },
    data () {
        return {
            editQuestionForm: false
        }
    },
    computed: {

    },
    created () {

    },
    methods: {
        deleteQuestion () {
            const con = confirm('Do You Want To Delete Question?')

            if (!con) {
                return
            }
            axios.delete(`/api/questions/${this.question.id}`)
                .then(res => {
                    this.$emit('deleteQuestion', this.question)
                })
        }

    }
}
</script>
