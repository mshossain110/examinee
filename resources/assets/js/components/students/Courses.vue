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
                            <div class="input-group mb-3">
                                <input
                                    v-model="searchChourse"
                                    type="text"
                                    class="form-control"
                                    placeholder="search"
                                    aria-label="search"
                                    aria-describedby="basic-addon2"
                                >
                                <div class="input-group-append">
                                    <span
                                        id="basic-addon2"
                                        class="input-group-text"
                                    ><i class="fas fa-search" /></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row StudentCourse">
                <div
                    v-for="course in displaycourses"
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
            courses: [],
            searchChourse: ''
        }
    },
    computed: {
        displaycourses () {
            let c = this.courses.slice()
            if (this.searchChourse) {
                c = c.filter(co => {
                    return co.title.toLowerCase().indexOf(this.searchChourse) !== -1
                })
            }
            return c
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
