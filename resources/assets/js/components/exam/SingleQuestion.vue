<template>
    <div
        class="card mt-1 border-0"
    >
        <div class="card-header d-flex justify-content-between">
            <div>
                {{ question.question }}
            </div>
            <div class="card-action">
                <a
                    href="#"
                    class="btn btn-primary  btn-sm"
                    @click.prevent="editQuestionForm = !editQuestionForm"
                ><i class="fas fa-edit" /></a>

                <a
                    href="#"
                    class="btn btn-primary  btn-sm"
                    @click.prevent="deleteExam"
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
        deleteExam () {
            const con = confirm('Do You Want To Delete Exam?')

            if (!con) {
                return
            }
            axios.delete(`/api/questions/${this.question.id}`)
                .then(res => {})
        }

    }
}
</script>
