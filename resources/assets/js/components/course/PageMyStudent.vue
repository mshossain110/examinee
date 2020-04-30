<template>
    <div class="page">
        <div class="card mt-5">
            <div class="card-header">
                <h3>Student List</h3>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li
                        v-for="(student,i) in students"
                        :key="i"
                        class="list-group-item d-flex"
                    >
                        <div class="avator">
                            <img
                                src="https://www.gravatar.com/avatar/64e1b8d34f425d19e1ee2ea7236d3028?s=40&amp;d=mp&amp;r=g"
                                class="rounded-circle"
                            >
                        </div>
                        <span class="student-name">{{ student.firstname }} {{ student.lastname }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            students: []
        }
    },
    computed: {

    },
    created () {
        this.getstudent()
    },
    methods: {
        getstudent () {
            axios.get(`/api/courses/${this.$route.params.id}/students`)
                .then(res => {
                    this.students = res.data.data
                })
        }

    }
}
</script>
