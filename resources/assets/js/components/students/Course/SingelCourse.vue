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
                                :to="{name: 'singellesson', params: {course: course.slug}}"
                                class="btn btn-primary mr-4"
                            >
                                Start Learning
                            </RouterLink>
                            <button
                                type="button"
                                class="btn btn-primary mr-4"
                            >
                                Add to watchlist
                            </button>
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
        <section class="lesson_part">
            <div class="back">
                <div class="row">
                    <div class="col-2">
                        <a href="#"><i class="fas fa-arrow-left mr-2" />Back To Main</a>
                    </div>
                    <div class="col-6">
                        <p>Latest Episode: <a href="#">Two-Way Databinding Review</a></p>
                    </div>
                    <div class="col-2">
                        <i class="fab fa-facebook-f mr-2" />
                        <i class="fab fa-twitter" />
                    </div>
                    <div class="col-2 d-flex justify-content-around">
                        <p>43% Complete</p>
                        <i class="fas fa-eye-slash" />
                    </div>
                </div>
            </div>
        </section>
        <Sessions
            v-if="!loading"
            :course="course"
        />
    </div>
</template>
<script>
import Sessions from './Sessions'
export default {
    components: {
        Sessions
    },
    data: () => ({
        loading: false,
        course: {}
    }),
    created () {
        this.getCourse()
    },
    methods: {
        getCourse () {
            if (this.loading) {
                return
            }
            this.loading = true
            const params = {
                course: this.$route.params.course
            }
            axios.get(`/api/courses/my-courses/${params.course}`)
                .then(res => {
                    this.course = res.data.data
                    this.loading = false
                })
        }
    }
}
</script>
