<template>
    <section>
        <div class="container">
            <div class="row py-3">
                <div class="col">
                    <h3>My Courses</h3>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col">
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
                        <div class="col">
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
                    </div>
                </div>
            </div>
            <div class="row StudentCourse">
                <div
                    v-for="course in courses"
                    :key="course.id"
                    class="col col-3"
                >
                    <Course
                        :course="course"
                        class="is-link"
                        progress
                        buttonable
                        @click.native.prevent="clickOnCourse(course)"
                    />
                </div>
            </div>
        </div>
    </section>
</template>
<script>

import Course from '@c/common/Course'
export default {
    components: {
        Course
    },
    data () {
        return {
            courses: []
        }
    },
    created () {
        this.getcourses()
    },
    methods: {
        getcourses () {
            axios.get('/api/courses/my-courses')
                .then(res => {
                    this.courses = res.data.data
                })
        },
        clickOnCourse (course) {
            this.$router.push({
                name: 'singleResource',
                params: {
                    course: course.id
                }
            })
        }
    }
}
</script>
