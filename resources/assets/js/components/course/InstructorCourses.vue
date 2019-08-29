<template>
    <div class="row course-list">
        <div
            v-for="course in courses"
            :key="course.id"
            class="col col-3"
        >
            <div class="card mb-3">
                <img
                    src=""
                    class="card-img-top"
                    alt=""
                >
                <div class="card-body">
                    <h5 class="card-title">
                        {{ course.title }}
                    </h5>
                    <p class="card-text">
                        {{ course.subtitle }}
                    </p>
                    <a
                        href="#"
                        class="btn btn-primary"
                    >More</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            courses: []
        }
    },
    computed: {

    },
    created () {
        this.getCourses()
    },
    methods: {
        getCourses () {
            axios.get('/api/course')
                .then(res => {
                    this.courses = res.data.data
                })
        }
    }
}
</script>
