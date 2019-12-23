<template>
    <div class="newexam">
        <form
            class="form-horizontal border bg-light p-5"
            @submit.prevent="submit"
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
                        v-model="exam.description"
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
                        {{ exam.id ? 'Update Exam': 'Create Exam' }}
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
        submit () {
            const params = {
                title: this.exam.title,
                description: this.exam.description
            }

            if (!this.exam.id) {
                axios.post(`/api/exams`, params)
                    .then(res => {
                        this.$emit('new-exam', res.data.data)
                        this.exam.title = ''
                        this.exam.description = ''
                    })
            } else {
                axios.put(`/api/exams/${this.exam.id}`, params)
                    .then(res => {
                        this.$emit('edit-exam', res.data.data)
                    })
            }
        }
    }
}
</script>
