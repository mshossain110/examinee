<template>
    <div>
        <section class="course_head">
            <div class="container">
                <div class="row">
                    <div class="col-8 course_text pt-3">
                        <div class="start_text">
                            <h5>{{ course.title }}</h5>
                            <p>{{ course.subtitle }}</p>
                            <p>{{ course.description }}</p>
                        </div>

                        <div class="icon pt-3">
                            <i class="fas fa-equals mr-2">Eiual</i>
                            <i class="fas fa-book-open mr-2">Episode</i>
                            <i class="fas fa-clock mr-2">Duration</i>
                        </div>

                        <div class="start_button pt-3">
                            <RouterLink
                                :to="{name: 'singlelesson', params: {course: course.slug}}"
                                class="btn btn-primary mr-4"
                            >
                                Start Learning
                            </RouterLink>

                            <button
                                type="button"
                                class="btn btn-info"
                            >
                                Add To Subcribe
                            </button>
                        </div>
                    </div>

                    <div class="col-4 course_logo pt-3 pl-5">
                        <img
                            src="https://www.isasa.org/wp-content/uploads/2018/05/systemic-evaluation.jpg"
                            alt=""
                        >
                        <h5>Let's get started!</h5>
                    </div>
                </div>
            </div>
        </section>

        <Sessions
            v-if="!loading"
            :course="course"
        />
        <section>
            <div class="row justify-content-center">
                <div
                    class="col-10"
                >
                    <div
                        class="card"
                    >
                        <img
                            class="card-img-top"
                            src="/"
                            alt="Card image cap"
                        >
                        <div class="card-body">
                            <p class="card-text">
                                Some quick example text to build on the card title and make up the bulk of the card's content.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
import Sessions from './Sessions'
export default {
    components: {
        Sessions
    },
    props: {
        course: {
            type: Object,
            required: true
        }
    },
    data: () => ({
        loading: false
    }),
    created () {
        // this.getCourse()
    },
    methods: {
        // getCourse () {
        //     if (this.loading) {
        //         return
        //     }
        //     this.loading = true
        //     const params = {
        //         course: this.$route.params.course
        //     }
        //     axios.get(`/api/courses/my-courses/${params.course}`)
        //         .then(res => {
        //             this.course = res.data.data
        //             this.loading = false
        //         })
        // }
    }
}
</script>
