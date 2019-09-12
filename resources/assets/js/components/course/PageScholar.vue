<template>
    <div class="page-scholar">
        <section>
            <div class="container-fluid bg-primary text-light pt-5">
                <div class="page-title text-center">
                    <h3>Instructor Courses</h3>
                    <nav class="nav text-light justify-content-center">
                        <RouterLink
                            class="nav-link"
                            :to="{name: 'course'}"
                        >
                            Courses
                        </RouterLink>

                        <RouterLink
                            class="nav-link"
                            :to="{name: 'exam'}"
                        >
                            Exams
                        </RouterLink>

                        <RouterLink
                            class="nav-link"
                            :to="{name: 'my-students'}"
                        >
                            My Studentes
                        </RouterLink>

                        <RouterLink
                            class="nav-link"
                            :to="{name: 'discussion'}"
                        >
                            Discussions
                        </RouterLink>
                    </nav>
                </div>
            </div>
        </section>
        <div>
            <div class="container">
                <RouterView />
            </div>
        </div>
    </div>
</template>

<script>
import router from './routers'
export default {
    data () {
        return {

        }
    },
    computed: {

    },
    created () {
        this.$router.addRoutes(router)
    },
    methods: {

    }
}
</script>
