<template>
    <div class="col-10 mt-2">
        <div class="page-title mb-5">
            <h1>Details of the course</h1>
            <div class="breadcums-aria">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Library</a>
                        </li>
                        <li
                            class="breadcrumb-item active"
                            aria-current="page"
                        >
                            Data
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="title">
            <h2>{{ course.title }}</h2>
        </div>
        <div class="contant">
            {{ course.description }}
        </div>
    </div>
</template>
<script>
export default {
    data () {
        return {
            course: {}
        }
    },
    computed: {

    },
    created () {
        this.getCourse()
    },
    methods: {
        getCourse () {
            axios.get(`/api/course/${this.$route.params.course}`)
                .then(res => {
                    this.course = res.data.data
                })
        }
    }
}
</script>
