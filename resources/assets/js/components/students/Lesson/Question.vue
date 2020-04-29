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
    })
}
</script>

<style>

</style>
