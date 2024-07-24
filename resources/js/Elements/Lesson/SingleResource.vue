<template>
    <div class="resource-single sidebar">
        <div
            v-if="!loading"
            class="session"
        >
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
        <Loading
            v-if="loading"
            spinner
        />
        <div v-else-if="!hasResource">
            <p>Can not find any exam or lesson on this course</p>
        </div>
        <RouterView v-else />
    </div>
</template>
<script>
import Session from './Session'
export default {
    components: {
        Session
    },
    data: () => ({
        loading: false,
        sessions: []
    }),
    computed: {
        hasResource () {
            let hasResource = false
            for (let index = 0; index < this.sessions.length; index++) {
                if (this.sessions[index].resources.length) {
                    hasResource = true
                    break
                }
            }

            return hasResource
        },
        firstResource () {
            let firstResource = false
            for (let index = 0; index < this.sessions.length; index++) {
                if (this.sessions[index].resources.length) {
                    firstResource = this.sessions[index].resources[0]
                    break
                }
            }

            return firstResource
        }
    },
    created () {
        this.getSessions()
    },
    methods: {
        getSessions () {
            if (this.loading) {
                return
            }
            this.loading = true
            const params = {
                id: this.$route.params.course
            }
            axios.get(`/api/courses/${params.id}/sessions`)
                .then(res => {
                    this.sessions = res.data.data
                    if (this.$route.name === 'singleResource') {
                        this.redirectFirstResource()
                    }
                })
                .finally(() => {
                    this.loading = false
                })
        },
        redirectFirstResource () {
            if (this.firstResource.pivot.sessionable_type.indexOf('Lesson') !== -1) {
                this.$router.push({
                    name: 'singleLesson',
                    params: {
                        course: this.$route.params.course,
                        lesson: this.firstResource.id
                    }
                })
            } else {
                this.$router.push({
                    name: 'singleExam',
                    params: {
                        course: this.$route.params.course,
                        exam: this.firstResource.id
                    }
                })
            }
        }
    }
}
</script>
