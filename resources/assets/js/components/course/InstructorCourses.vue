<template>
    <div class="row course-list">
        <div
            v-for="course in courses"
            :key="course.id"
            class="col col-3"
        >
            <RouterLink :to="{name: 'course-single', params: { course : course.id }}">
                <div class="card mb-3">
                    <img
                        v-if="course.thumbnail"
                        :src="course.thumbnail.public_path"
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
                    </div>
                </div>
            </RouterLink>
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
