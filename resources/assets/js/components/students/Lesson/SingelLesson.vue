<template>
    <div class="lesson-single sidebar">
        <section class="video">
            <img
                src="https://camo.githubusercontent.com/6e39997f79038055aff7479361bc8560d0ad5b28/68747470733a2f2f73332d75732d776573742d322e616d617a6f6e6177732e636f6d2f6e756269782e63612f6769746875622f6578616d706c652e676966"
                alt=""
                width="100%"
            >
        </section>

        <Sessions
            v-if="!loading && lesson.courses.length"
            :course="lesson.courses[0]"
        />

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
                                    Descussions
                                </a>
                                <a class="list-group-item">
                                    Author
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="overview">
                                <h3 class="text-uppercase">
                                    ABOUT THIS Lesson
                                </h3>
                                <strong>{{ lesson.title }}</strong>
                                <p>{{ lesson.short_text }}</p>

                                <h3 class="text-uppercase">
                                    Details
                                </h3>

                                <div>{{ lesson.full_text }}</div>
                            </div>
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
    data: () => ({
        loading: false,
        lesson: {}
    }),
    created () {
        this.getLessson()
    },
    methods: {
        getLessson () {
            if (this.loading) {
                return
            }
            this.loading = true

            const params = {
                id: this.$route.params.lesson
            }

            axios.get(`/api/lessons/${params.id}`, { params })
                .then(res => {
                    this.lesson = res.data.data
                    this.loading = false
                })
        }
    }
}
</script>
