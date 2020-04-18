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
                        >Create session</a>
                    </div>
                </div>
            </div>
            <NewSession
                v-if="create"
                @store="newSession"
            />
            <Sessions :sessions="sessions" />
        </div>

        <div class="col-md-3">
            suggestion how to create courses
        </div>
    </div>
</template>
<script>
import Sessions from './Sessions'
import NewSession from './NewSession'
export default {
    components: {
        Sessions,
        NewSession
    },
    data () {
        return {
            create: false,
            sessions: []
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
                    this.sessions = res.data.data
                })
        },
        newSession (session) {
            this.sessions.push(session)
            this.create = false
        }
    }
}
</script>
