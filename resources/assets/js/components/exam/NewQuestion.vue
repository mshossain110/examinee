<template>
    <div class="newquestion">
        <form class="form-horizontal">
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
                            class="btn btn-secondary active"
                            data-title="0"
                        >
                            Objective
                        </button>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-title="1"
                        >
                            True/False
                        </button>

                        <input
                            type="hidden"
                            name="qtype"
                            value="0"
                        >
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label
                    for="title"
                    class="col-md-4 control-label"
                >Question</label>

                <div class="col">
                    <textarea
                        id="question"
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
                        <tr class="option-input option-0">
                            <td>
                                <input
                                    class="form-control"
                                    type="checkbox"
                                    name="answer[]"
                                    value="0"
                                >
                            </td>
                            <td>
                                <textarea
                                    class="form-control"
                                    name="options[0]"
                                />
                            </td>
                            <td>
                                <button class="btn btn-danger remove">
                                    remove
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button
                    id="addoption"
                    class="btn btn-secondary"
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
                        type="number"
                        class="form-control"
                        name="mark"
                        value="1"
                    >

                    <input
                        type="hidden"
                        class="form-control"
                        name="nagetive_mark"
                        value="0"
                    >
                </div>

                <div class="col">
                    <label
                        for="nagetive_mark"
                        class="control-label mr-2"
                    >Mark </label>
                    <input
                        type="number"
                        class="form-control"
                        name="nagetive_mark"
                        value="0"
                    >
                </div>

                <div class="col">
                    <label
                        for="nagetive_mark"
                        class="control-label mr-2"
                    >Defficulty </label>
                    <select
                        id="defficulty"
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
                    for="title"
                    class="col-md-4 control-label"
                >Answer Hint (Optional)</label>

                <div class="col">
                    <textarea
                        id="answer_hint"
                        class="form-control"
                        name="hint"
                    />
                </div>
            </div>
            <div class="form-group">
                <label
                    for="title"
                    class="col-md-4 control-label"
                >Answer Explanation (Optional)</label>

                <div class="col">
                    <textarea
                        id="explanation"
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

            }
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
