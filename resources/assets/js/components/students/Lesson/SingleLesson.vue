<template>
    <div class="single-lesson">
        <Loading
            v-if="loading"
            spinner
        />
        <section
            v-if=" lesson.type == 'Video'"
            class="video"
        >
            <VideoPreview
                :file="lesson.object"
            />
        </section>

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

import VideoPreview from './../../common/dropzone/VideoPreview'
export default {
    components: {
        VideoPreview
    },
    data: () => ({
        loading: false,
        lesson: {}
    }),
    watch: {
        '$route' () {
            this.getLessson()
        }
    },
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

<style>

</style>
