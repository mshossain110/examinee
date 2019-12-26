<template>
    <div class="row">
        <div class="col-md-9">
            <div class="page-title mb-5">
                <h1>Course Lessons</h1>
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
            <div class="contant">
                <div class="row">
                    <div class="col col-md-2 offset-md-6 ">
                        <div class="dropdown">
                            <a
                                id="dropdownMenuLink"
                                class="btn btn-secondary dropdown-toggle"
                                href="#"
                                role="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                            >
                                Sort By
                            </a>

                            <div
                                class="dropdown-menu"
                                aria-labelledby="dropdownMenuLink"
                            >
                                <a
                                    class="dropdown-item"
                                    href="javascript:void(0)"
                                ><span>Recently Accessed</span></a>
                                <a
                                    class="dropdown-item"
                                    href="javascript:void(0)"
                                ><span>Recently Enrolled</span></a>
                                <a
                                    class="dropdown-item"
                                    href="javascript:void(0)"
                                ><span>Title: A-to-Z</span></a>
                                <a
                                    class="dropdown-item"
                                    href="javascript:void(0)"
                                ><span>Title: Z-to-A</span></a>
                                <a
                                    class="dropdown-item"
                                    href="javascript:void(0)"
                                ><span>Completion: 0% to 100%</span></a>
                                <a
                                    class="dropdown-item"
                                    href="javascript:void(0)"
                                ><span>Completion: 100% to 0%</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-2">
                        <form
                            class=""
                            _lpchecked="1"
                        >
                            <label
                                for="search-courses-input"
                                class="control-label sr-only"
                            >Search my courses</label><span class="input-group"><input
                                id="search-courses-input"
                                placeholder="Search my courses"
                                required=""
                                autocomplete="off"
                                class="form-control"
                                value=""
                            ><span class="input-group-btn"><button
                                aria-label="Search my courses"
                                type="submit"
                                class="btn btn-secondary"
                                disabled=""
                            ><span class="fas fa-search" /></button>
                            </span>
                            </span>
                        </form>
                    </div>
                    <div class="col col-md-2">
                        <a
                            href=""
                            class="btn btn-primary"
                            @click.prevent="create = !create"
                        >Create Lessons</a>
                    </div>
                </div>
                <div
                    v-if="create"
                    class="row mt-5"
                >
                    <div class="col">
                        <NewLesson @new-lesson="newLesson" />
                    </div>
                </div>
            </div>
            <div class="lessons-list">
                <div
                    v-for="l in lessons"
                    :key="l.id"
                    class="row mt-3"
                >
                    <div class="col-2">
                        <img
                            src="https://getbrainybox.com/wp-content/uploads/2016/08/montessori-lesson-plan-1024x685.jpg"
                            alt=""
                            width="150"
                            height="80"
                        >
                    </div>
                    <div class="col">
                        <h1>{{ l.title }}</h1>
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>views 1,243,067</h6>
                            </div>
                            <div>
                                <i class="far fa-trash-alt" />
                                <i class="far fa-edit" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            suggestion how to create courses
        </div>
    </div>
</template>
<script>
import NewLesson from './NewLesson'
export default {
    components: {
        NewLesson
    },
    data () {
        return {
            create: false,
            lessons: []
        }
    },
    created () {
        this.getLessons()
    },
    methods: {
        getLessons () {
            const courseId = this.$route.params.id
            const params = {
            }
            axios.get(`/api/courses/${courseId}/sessions`, { params: params })
                .then(res => {
                    this.lessons = res.data.data
                })
        },
        newLesson (lesson) {
            this.lessons.push(lesson)
            this.create = false
        }
    }
}
</script>
