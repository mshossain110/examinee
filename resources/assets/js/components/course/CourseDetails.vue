<template>
    <div class="row">
        <div class="col-9 mt-2">
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
                <button
                    type="button"
                    class="btn btn-dark"
                    @click="editCourse = !editCourse"
                >
                    Edit Course
                </button>
            </div>
            <div
                v-if="editCourse"
                class="mt-3"
            >
                <NewCourse :course="course" />
            </div>
            <div class="title">
                <h4>Title</h4>
                <h3>{{ course.title }}</h3>
            </div>
            <div>
                <h4>Sub Title</h4>
                <p>{{ course.subtitle }}</p>
            </div>
            <div>
                <h4>Slug</h4>
                <p>{{ course.slug }}</p>
            </div>
            <div>
                <h4>Description</h4>
                <p>{{ course.description }}</p>
            </div>
            <div>
                <h4>Features</h4>
                <p>{{ course.features }}</p>
            </div>
            <div>
                <h4>Requirements</h4>
                <p>{{ course.requirements }}</p>
            </div>
        </div>
        <div class="col-3">
            <div
                class="card course-overview mt-3"
            >
                <div class="card-header">
                    Overview
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Price</strong> <span>{{ course.price }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Discount</strong> <span>{{ course.discount }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Status</strong> <span>{{ course.status }}</span>
                    </li>

                    <li class="list-group-item">
                        <strong>Certified</strong> <span>{{ course.certified }}</span>
                    </li>

                    <li class="list-group-item">
                        <strong>Start Date</strong> <span>{{ course.start_date }}</span>
                    </li>

                    <li class="list-group-item">
                        <strong>Lessons</strong> <span>{{ course.lesson_count }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
import NewCourse from './NewCourse'
export default {
    components: {
        NewCourse
    },
    data () {
        return {
            editCourse: false
        }
    },
    computed: {
        course () {
            return this.$store.state.Course.course
        }
    },
    created () {

    },
    methods: {

    }
}
</script>

<style lang="scss">
    .course-overview {
        background-color: #eae4cf;
        .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    }
</style>
