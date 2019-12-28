<template>
    <div class="newsession">
        <form
            class="form-horizontal border bg-light p-5"
            @submit.prevent="submit"
        >
            <div class="form-group">
                <label
                    for="title"
                    class="col-md-4 control-label"
                >Session Title</label>

                <div class="col">
                    <input
                        id="title"
                        v-model="session.title"
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
                        v-model="session.description"
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
                        {{ session.id ? 'Update Session': 'Create Session' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        session: {
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
                title: this.session.title,
                description: this.session.description,
                course_id: this.$route.params.id
            }

            if (!this.session.id) {
                axios.post(`/api/sessions`, params)
                    .then(res => {
                        this.$emit('store', res.data.data)
                        this.session.title = ''
                        this.session.description = ''
                    })
            } else {
                axios.put(`/api/sessions/${this.session.id}`, params)
                    .then(res => {
                        this.$emit('update', res.data.data)
                    })
            }
        }
    }
}
</script>
