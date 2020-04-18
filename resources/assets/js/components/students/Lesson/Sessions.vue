<template>
    <div class="session">
        <div class="row">
            <div class="col-12">
                <div
                    v-for="session in sessions"
                    :key="session.id"
                >
                    <Session :session="session" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Session from './Session'
export default {
    components: {
        Session
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
