<template>
    <div class="session container">
        <div class="row mt-5 justify-content-center">
            <div
                v-for="session in sessions"
                :key="session.id"
                class="col-10"
            >
                <div class="s">
                    <strong>{{ session.title }}</strong>
                </div>
                <div
                    v-for="( resource, i ) in session.resources"
                    :key="`${i}-${resource.id}`"
                    class="mb-3"
                >
                    <Resources :resource="resource" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Resources from './Resources'
export default {
    components: {
        Resources
    },
    props: {
        course: {
            type: Object,
            required: true
        }
    },
    data: () => ({
        loading: false,
        sessions: []
    }),
    created () {
        this.getSessions()
    },
    methods: {
        getSessions () {
            if (this.loading) {
                return
            }
            this.loading = true
            axios.get(`/api/courses/${this.course.id}/sessions`)
                .then(res => {
                    this.sessions = res.data.data
                    this.loading = false
                })
        }
    }
}
</script>

<style>
</style>
