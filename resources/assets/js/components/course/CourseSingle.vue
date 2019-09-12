<template>
    <div class="page page-coures">
        <div class="row">
            <div class="col-2">
                <div class="warp">
                    <div class="menu">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <RouterLink
                                    class="nav-link"
                                    :to="{name: 'coures-details'}"
                                >
                                    Details
                                </RouterLink>
                            </li>
                            <li class="list-group-item">
                                <RouterLink
                                    class="nav-link"
                                    :to="{name: 'coures-lessons'}"
                                >
                                    Lesson
                                </RouterLink>
                            </li>
                            <li class="list-group-item">
                                <RouterLink
                                    class="nav-link"
                                    :to="{name: 'coures-exams'}"
                                >
                                    Exam
                                </RouterLink>
                            </li>
                            <li class="list-group-item">
                                <RouterLink
                                    class="nav-link"
                                    :to="{name: 'coures-students'}"
                                >
                                    Student
                                </RouterLink>
                            </li>
                            <li class="list-group-item">
                                <RouterLink
                                    class="nav-link"
                                    :to="{name: 'coures-discuss'}"
                                >
                                    Discuss
                                </RouterLink>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <RouterView />
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {

        }
    },
    computed: {

    },
    created () {

    },
    methods: {

    }
}
</script>
<style lang="scss">
.page-coures{
    .menu{
        margin-top: 120px;
        a{
            text-decoration: none;

        }
        li{
            &:hover{
                background-color: #ececec
            }
        }
    }
}
</style>
