<template>
    <div class="newquestion">
        <form
            class="form-horizontal border bg-light p-5"
            @submit.prevent="submit"
        >
            <div class="heading">
                <h3>New Question</h3>
            </div>
            <div
                id="qtype"
                class="form-group"
            >
                <label
                    for="title"
                    class="col-md-4 control-label"
                >Question type</label>

                <div class="col">
                    <div
                        class="btn-group"
                        role="group"
                    >
                        <button
                            type="button"
                            class="btn btn-primary"
                            :class="{'active': question.qtype===1}"
                            @click.prevent="question.qtype=1"
                        >
                            Objective
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            :class="{'active': question.qtype===2}"
                            @click.prevent="question.qtype=2"
                        >
                            True/False
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label
                    for="question"
                    class="col-md-4 control-label"
                >Question</label>

                <div class="col">
                    <textarea
                        id="question"
                        v-model="question.question"
                        class="form-control"
                        name="question"
                        cols="100"
                        rows="8"
                    />
                </div>
            </div>

            <div class="form-group">
                <label
                    for="description"
                    class="col-md-4 control-label"
                >Options</label>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Currect Answere</th>
                            <th>Option</th>
                            <th />
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(q,index) in aoptions"
                            :key="index"
                            class="option-input option-o"
                        >
                            <td>
                                <input
                                    v-model="q.answer"
                                    class="form-control"
                                    type="checkbox"
                                >
                            </td>
                            <td>
                                <textarea
                                    v-model="q.option"
                                    class="form-control"
                                    name="options[o]"
                                />
                            </td>
                            <td>
                                <button
                                    v-if="aoptions.length>1"
                                    class="btn btn-danger remove"
                                    @click.prevent="removeOptin(index)"
                                >
                                    remove
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button
                    id="addoption"
                    class="btn btn-secondary"
                    @click.prevent="addMoreOption"
                >
                    Add More Option
                </button>
            </div>

            <div class="form-group form-row">
                <div class="col">
                    <label
                        for="mark"
                        class="control-label mr-2"
                    >Mark </label>
                    <input
                        id="mark"
                        v-model.number="question.mark"
                        type="number"
                        class="form-control"
                        value="1"
                    >
                </div>

                <div class="col">
                    <label
                        for="nagetive_mark"
                        class="control-label mr-2"
                    >Nagetive Mark </label>
                    <input
                        id="nagetive_mark"
                        v-model.number="question.nmark"
                        type="number"
                        class="form-control"
                        value="o"
                    >
                </div>

                <div class="col">
                    <label
                        for="defficulty"
                        class="control-label mr-2"
                    >Defficulty </label>
                    <select
                        id="defficulty"
                        v-model.number="question.defficulty"
                        class="form-control"
                        name="defficulty"
                    >
                        <option value="1">
                            Level 1
                        </option>
                        <option value="2">
                            Level 2
                        </option>
                        <option value="3">
                            Level 3
                        </option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label
                    for="answer_hint"
                    class="col-md-4 control-label"
                >Answer Hint (Optional)</label>

                <div class="col">
                    <textarea
                        id="answer_hint"
                        v-model="question.hint"
                        class="form-control"
                        name="hint"
                    />
                </div>
            </div>
            <div class="form-group">
                <label
                    for="explanation"
                    class="col-md-4 control-label"
                >Answer Explanation (Optional)</label>

                <div class="col">
                    <textarea
                        id="explanation"
                        v-model="question.explanation"
                        class="form-control"
                        name="answer_explanation"
                    />
                </div>
            </div>

            <input
                type="hidden"
                name="todo"
            >

            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Create Question
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        question: {
            type: Object,
            default () {
                return {
                    qtype: 1,
                    question: '',
                    options: [],
                    answers: [],
                    hint: '',
                    mark: 1,
                    nmark: 0,
                    explanation: '',
                    defficulty: 1
                }
            }
        },
        exam: {
            type: Object,
            default: null
        }
    },
    data () {
        return {
            aoptions: [{ answer: '', option: '', id: this.getRandomId() }]
        }
    },
    computed: {

    },
    mounted () {
        if (this.question.options.length) {
            this.aoptions = []

            this.question.options.map(o => {
                const option = o
                option.answer = this.question.answers.indexOf(o.id) !== -1
                this.aoptions.push(option)
            })
        }
    },
    methods: {
        submit () {
            const params = this.question
            params.answers = []
            params.options = []
            this.aoptions.map(a => {
                if (a.answer) {
                    params.answers.push(a.id)
                }
                delete a.answer
                params.options.push(a)
            })
            if (this.exam) { params.exam_id = this.exam.id }
            if (!this.question.id) {
                axios.post(`/api/questions`, params)
                    .then(res => {
                        this.$emit('store', res.data.data)
                    })
            } else {
                axios.put(`/api/questions/${this.question.id}`, params)
                    .then(res => (
                        this.$emit(`update`, res.data.data)
                    ))
            }
        },
        addMoreOption () {
            this.aoptions.push({ answer: '', option: '', id: this.getRandomId() })
        },
        removeOptin (index) {
            this.aoptions.splice(index, 1)
        },
        getRandomId () {
            return `${Date.now()}-${parseInt(Math.random() * 1000)}`
        }

    }
}
</script>
