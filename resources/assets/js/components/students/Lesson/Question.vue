<template>
    <div
        class="card-body px-5"
    >
        <div

            class="row mt-5"
        >
            <div class="col-12 d-flex justify-content-between">
                <strong>Mark : {{ question.mark }}</strong>
                <strong>Nagative Mark: {{ question.nmark }}</strong>
            </div>
            <div class="col-12">
                <div class="question d-flex">
                    {{ question.question }}
                </div>
            </div>
        </div>

        <div

            class="row mt-5"
        >
            <div class="col">
                <div
                    v-for="option in question.options"
                    :key="option.id"
                    class="custom-control custom-checkbox"
                >
                    <input
                        :id="option.id"
                        v-model="answer"
                        :value="option.id"
                        type="checkbox"
                        class="custom-control-input"
                    >
                    <label
                        class="custom-control-label"
                        :for="option.id"
                    >{{ option.option }}</label>
                </div>
            </div>
        </div>
        <div
            v-if="question.hint"
            class="row mt-3"
        >
            <div class="col">
                <div class="hint">
                    <strong>Hint:</strong>
                    <p>{{ question.hint }}.</p>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col">
                <div class="next-button">
                    <button
                        type="button"
                        class="btn btn-outline-success"
                        @click="previous"
                    >
                        previous
                    </button>
                    <button
                        type="button"
                        class="btn btn-outline-success"
                        @click="next"
                    >
                        Next
                    </button>
                    <button
                        type="button"
                        class="btn btn-outline-dark"
                        @click="clearAns"
                    >
                        Clear Ans
                    </button>
                    <button
                        type="button"
                        class="btn btn-outline-danger"
                        @click="finish"
                    >
                        Finish
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        question: {
            type: Object,
            required: true
        },
        answers: {
            type: Array,
            required: true
        }
    },
    data: () => ({
        answer: []
    }),
    mounted () {
        this.answer = this.answers.find(a => a.id === this.question.id).answer || []
    },
    methods: {
        clearAns () {
            this.answer = []
        },
        previous () {
            const ans = {}
            ans[this.question.id] = this.answer
            this.$emit('previous', ans)
        },
        next () {
            const ans = {}
            ans[this.question.id] = this.answer
            this.$emit('next', ans)
        },
        finish () {
            const ans = {}
            ans[this.question.id] = this.answer
            this.$emit('finish', ans)
        }

    }
}
</script>

<style>

</style>
