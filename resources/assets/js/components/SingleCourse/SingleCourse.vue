<template>
    <div>
        <section class="course_head">
            <div class="container">
                <div class="row">
                    <div class="col-8 course_text pt-3">
                        <div class="start_text">
                            <h5>{{ course.title }}</h5>
                            <p>{{ course.subtitle }}</p>
                            <div
                                v-if="course.features"
                                class="feature"
                            >
                                <h4>Features</h4>

                                <ul class="list-unstyled">
                                    <li
                                        v-for="(feature,i) in course.features"
                                        :key="i"
                                    >
                                        <i class="fas fa-check mr-2 text-success" /> {{ feature }}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="icon pt-3">
                            <i class="fas fa-equals mr-2">Eiual</i>
                            <i class="fas fa-book-open mr-2">Episode</i>
                            <i class="fas fa-clock mr-2">Duration</i>
                        </div>

                        <div class="start_button pt-3">
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click.prevent="startLearning"
                            >
                                Start Learning
                            </button>

                            <button
                                type="button"
                                disabled
                                class="btn btn-info"
                            >
                                Add To Subcribe
                            </button>
                        </div>
                    </div>

                    <div class="col-4">
                        <div
                            class="card payment"
                        >
                            <div class="card-img">
                                <img
                                    class="card-img-top"
                                    :src="thumbnail"
                                    alt="Card image cap"
                                >
                            </div>

                            <div class="card-body">
                                <div class="card-title">
                                    <h5>
                                        ${{ course.price }}
                                    </h5>
                                    <button
                                        disabled
                                        type="button"
                                        class="btn btn-info"
                                    >
                                        Add to cart
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-primary"
                                        @click.prevent="startLearning"
                                    >
                                        Start Learning
                                    </button>
                                </div>
                                <div class="detail">
                                    <ul>
                                        <li>full life time acces</li>
                                        <li>90 articles</li>
                                        <li>28.5 hours on-demand video</li>
                                        <li>Access on mobile and TV</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row justify-content-center m-5">
                    <div class="col-10">
                        <div v-html="course.description" />
                    </div>
                </div>
            </div>
        </section>
        <Sessions
            v-if="!loading"
            :course="course"
        />
        <section class="teacher-details container">
            <div class="row justify-content-center teacher-header">
                <div col-10>
                    <h4> About Teacher</h4>
                </div>
            </div>

            <div class="row justify-content-center teacher-body mx-3">
                <div
                    v-for="teacher in course.teachers"
                    :key="teacher.id"
                    class="col-6"
                >
                    <div

                        class="card mb-5"
                    >
                        <div class="card-header d-flex border-0">
                            <img
                                class="teacher-img"
                                src="https://www.gravatar.com/avatar/79318fe1c6a4c441a937e9deef8a716e?s=200&d=mp&r=g"
                                alt="Card image cap"
                            >
                            <div class="card-title">
                                <strong>{{ teacher.full_name }}</strong>
                            </div>
                        </div>

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
    computed: {
        thumbnail () {
            if (this.course.thumbnail) return this.course.thumbnail.public_path

            return 'https://tricksinfo.net/wp-content/uploads/2019/07/533430_ce1e_3-750x405.jpg'
        }
    },
    methods: {
        startLearning () {
            if (this.loading) {
                return
            }

            this.loading = true

            axios.post(`/subscribe/${this.course.id}`)
                .then((res) => {
                    window.location.replace('/learning/my-courses')
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        window.location.replace('/login')
                    }
                })
                .finally(() => {
                    this.loading = false
                })
        }
    }
}
</script>
