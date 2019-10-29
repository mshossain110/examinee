<template>
    <div class="container-fluid page-coures">
        <div class="row">
            <div class="col-2 mt-3">
                <div

                    class="nav flex-column nav-pills"
                >
                    <RouterLink
                        class="nav-link"

                        exact-active-class="active"
                        :to="{name: 'coures-details'}"
                    >
                        Details
                    </RouterLink>
                    <RouterLink
                        exact-active-class="active"
                        class="nav-link"
                        :to="{name: 'coures-lessons'}"
                    >
                        Lessons
                    </RouterLink>
                    <RouterLink
                        exact-active-class="active"
                        class="nav-link"
                        :to="{name: 'course-exams'}"
                    >
                        Exams
                    </RouterLink>
                    <RouterLink
                        exact-active-class="active"
                        class="nav-link"
                        :to="{name: 'coures-students'}"
                    >
                        Students
                    </RouterLink>

                    <RouterLink
                        exact-active-class="active"
                        class="nav-link"
                        :to="{name: 'coures-discuss'}"
                    >
                        Discussions
                    </RouterLink>
                </div>
            </div>
            <div class="col-10">
                <RouterView />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {

        }
    },
    computed: {
        course () {
            return this.$store.state.Course.course
        }
    },
    created () {
        this.getCourse()
    },
    methods: {
        getCourse () {
            axios.get(`/api/course/${this.$route.params.id}`)
                .then(res => {
                    this.$store.commit('Course/setCourse', res.data.data)
                })
        }
    }
}
</script>
