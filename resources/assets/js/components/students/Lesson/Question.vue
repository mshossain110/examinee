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
                    v-for="(o, i) in question.options"
                    :key="i"
                    class="custom-control custom-checkbox"
                >
                    <input
                        :id="`ans-${i}`"
                        v-model="answer"
                        :value="o"
                        type="checkbox"
                        class="custom-control-input"
                    >
                    <label
                        class="custom-control-label"
                        :for="`ans-${i}`"
                    >{{ o }}</label>
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
        }
    },
    data: () => ({
        answer: []
    }),
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
