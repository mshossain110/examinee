<template>
    <div class="page-scholar">
        <section>
            <div class="container-fluid bg-primary text-light pt-5">
                <div class="page-title text-center">
                    <h3>Instructor Courses</h3>
                    <nav class="nav text-light justify-content-center">
                        <a
                            class="nav-link active"
                            href=""
                        >Courses</a>
                        <a
                            class="nav-link"
                            href="#"
                        >Exams</a>
                        <a
                            class="nav-link"
                            href="#"
                        >My Studentes</a>
                        <a
                            class="nav-link"
                            href="#"
                        >Discussion</a>
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
