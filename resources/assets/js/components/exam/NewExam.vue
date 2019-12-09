<template>
    <div class="newexam">
        <form
            class="form-horizontal"
            method="POST"
        >
            <div class="form-group">
                <label
                    for="title"
                    class="col-md-4 control-label"
                >Exam Title</label>

                <div class="col">
                    <input
                        id="title"
                        v-model="exam.title"
                        type="text"
                        class="form-control"
                        name="title"
                        required
                        autofocus
                    >
                </div>
            </div>

            <div class="form-group">
                <label
                    for="description"
                    class="col-md-4 control-label"
                >Description</label>

                <div class="col">
                    <textarea
                        id="description"
                        v-model="exam.descriptoon"
                        name="description"
                        class="form-control"
                        rows="8"
                    />
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Create Exam
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        exam: {
            type: Object,
            default () {
                return {
                    title: '',
                    description: ''
                }
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
