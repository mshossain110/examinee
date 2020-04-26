<template>
    <div class="single-exam exam sidebar">
        <section class="details">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="list-group list-group-horizontal-lg">
                                <a class="list-group-item">
                                    Overview
                                </a>
                                <a class="list-group-item">
                                    Author
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="overview">
                                <h3 class="text-uppercase">
                                    ABOUT THIS exam
                                </h3>
                                <strong>{{ exam.title }}</strong>

                                <h3 class="text-uppercase">
                                    Details
                                </h3>

                                <div>{{ exam.description }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
export default {
    components: {
    },
    data: () => ({
        loading: false,
        exam: {}
    }),
    watch: {
        '$route' () {
            this.getExam()
        }
    },
    created () {
        this.getExam()
    },
    methods: {
        getExam () {
            if (this.loading) {
                return
            }
            this.loading = true

            const params = {
                id: this.$route.params.exam
            }

            axios.get(`/api/exam/${params.id}`, { params })
                .then(res => {
                    this.exam = res.data.data
                    this.loading = false
                })
        }
    }
}
</script>
